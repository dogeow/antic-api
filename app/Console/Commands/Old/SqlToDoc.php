<?php

declare(strict_types=1);

namespace App\Console\Commands\Old;

use Illuminate\Console\Command;
use function App\Console\Commands\str_contains;
use const App\Console\Commands\PHP_EOL;

class SqlToDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sqltodoc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SQL 文件转 CSV 文档';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $tables = [
            'users',
        ];

        $file = file_get_contents('mysqlStruct.sql');
        $file .= "\nCREATE TABLE"; // 尾部增加

        foreach ($tables as $table) {
            $tableStart = strpos($file, (string) "CREATE TABLE `{$table}`");
            $createTableStart = substr($file, $tableStart);
            $tableNameStart = substr($createTableStart, 12); // 12 为「CREATE TABLE」
            $tableEnd = strpos($tableNameStart, 'CREATE TABLE');

            $migrateString = substr($createTableStart, 0, $tableEnd + 12);

            $migrate = explode(PHP_EOL, $migrateString);

            $array = [
                'name' => null, // 表名
                'comment' => null, // 注释
                'fields' => null, // 字段名
            ];

            foreach ($migrate as $line) {
                $comment = '';
                $nullable = null;

                if (preg_match('/CREATE TABLE `(.*?)`/', $line, $matches)) {
                    $array['name'] = $matches['1'];
                } elseif (preg_match('/ENGINE ?=.*?COMMENT ?= ?\'(.*?)\'/', $line, $matches)) {
                    $array['comment'] = $matches['1'];
                } elseif (preg_match('/`id` +(.*?) NOT NULL AUTO_INCREMENT/', $line, $matches)) {
                    $array['fields'][] = [
                        'id' => 'id',
                        'comment' => 'ID',
                        'type' => $matches[1],
                        'nullable' => 'FALSE',
                        'index' => '',
                    ];
                } elseif (preg_match('/PRIMARY KEY +\(`(.*?)`\)/', $line, $matches)) {
                    foreach ($array['fields'] as $key => $field) {
                        if ($field['id'] === $matches[1]) {
                            if ($array['fields'][$key]['index'] === '') {
                                $array['fields'][$key]['index'] .= '主键';
                            } else {
                                $array['fields'][$key]['index'] .= '|主键';
                            }
                            break;
                        }
                    }
                } elseif (preg_match('/UNIQUE (INDEX|KEY).*?\(`(.*?)`\)/', $line, $matches)) {
                    foreach ($array['fields'] as $key => $field) {
                        if ($field['id'] === $matches[2]) {
                            if ($array['fields'][$key]['index'] === '') {
                                $array['fields'][$key]['index'] .= '唯一';
                            } else {
                                $array['fields'][$key]['index'] .= '|唯一';
                            }
                            break;
                        }
                    }
                } elseif (preg_match('/KEY.*?`.*?` ?\(`(.*?)`\)/', trim($line), $matches)) {
                    foreach ($array['fields'] as $key => $field) {
                        if ($field['id'] === $matches[1]) {
                            if ($array['fields'][$key]['index'] === '') {
                                $array['fields'][$key]['index'] .= '普通索引';
                            } else {
                                $array['fields'][$key]['index'] .= '|普通索引';
                            }
                            break;
                        }
                    }
                } elseif (preg_match('/KEY +`.*?`\(`(.*?)`\)/', trim($line), $matches)) {
                    foreach ($array['fields'] as $key => $field) {
                        if ($field['id'] === $matches[1]) {
                            if ($array['fields'][$key]['index'] === '') {
                                $array['fields'][$key]['index'] .= '普通索引';
                            } else {
                                $array['fields'][$key]['index'] .= '|普通索引';
                            }
                            break;
                        }
                    }
                } elseif (preg_match('/`(.*?)` +(.*?) +.*?$/', $line, $matches)) {
                    if (preg_match('/COMMENT +\'(.*?)\'/', $line, $matches2)) {
                        $comment = $matches2[1];
                    }
                    if (str_contains($line, 'NOT NULL')) {
                        $nullable = 'FALSE';
                    } elseif (str_contains($line, 'DEFAULT NULL')) {
                        $nullable = 'TRUE';
                    } elseif (str_contains($line, 'NULL COMMENT')) {
                        $nullable = 'TRUE';
                    } elseif (str_contains($line, 'DEFAULT')) {
                        if (preg_match('/DEFAULT \'(.*?)\'/', $line, $matches4)) {
                            $nullable = 'FALSE';
                        }
                    } elseif (preg_match('/text (COLLATE|CHARACTER|COMMENT)/i', $line, $mathes5)) {
                        $nullable = 'TRUE';
                    } elseif (preg_match('/CREATE VIEW /i', $line)) {
                        continue;
                    } elseif (preg_match('/DEFINER=.*?SQL SECURITY DEFINER/i', $line)) {
                        continue;
                    } elseif (preg_match('/ VIEW `.*?`/i', $line)) {
                        continue;
                    }

                    if (!isset($nullable)) {
                        exit('$nullable 为空：'.$line);
                    }

                    if (str_contains($line, '`id`') === false && preg_match(
                            '/int\(.*?\) UNSIGNED/',
                            $line,
                            $matches3
                        )) {
                        $unsigned = ' UNSIGNED';
                    }

                    $array['fields'][] = [
                        'id' => $matches[1],
                        'comment' => $comment ?? '',
                        'type' => isset($unsigned) ? $matches[2].$unsigned : $matches[2],
                        'nullable' => $nullable,
                        'index' => '',
                    ];
                }
            }

//        表名称,company_table_records,,,,,
//        表注释,企业相关表操作记录,,,,,
//        序号,字段名,备注,数据类型,是否为空,索引,备注
//        1,id,ID,int(11),FALSE,主键,
//        2,table_name,表名称,varchar(50),FALSE,,
//        3,user_code,用户标识符,varchar(50),FALSE,,
            echo "表名称,{$array['name']},,,,,".PHP_EOL;
            echo "表注释,{$array['comment']},,,,,".PHP_EOL;
            echo '序号,字段名,备注,数据类型,是否为空,索引,备注'.PHP_EOL;

            $no = 1;
            foreach ($array['fields'] as $v) {
                echo "{$no},{$v['id']},{$v['comment']},{$v['type']},{$v['nullable']},{$v['index']},".PHP_EOL;
                $no++;
            }
            echo str_repeat((string) PHP_EOL, 3);
        }
    }
}

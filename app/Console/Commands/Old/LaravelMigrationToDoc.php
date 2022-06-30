<?php

declare(strict_types=1);

namespace App\Console\Commands\Old;

use Illuminate\Console\Command;

class LaravelMigrationToDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:toDoc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    final public const TABLES = [
        'users',
    ];

    final public const PRIMARY_KEY = [
        'id' => 'id',
        'name' => '备注',
        'type' => 'int(11)',
        'nullable' => 'FALSE',
        'index' => '主键',
        'comment' => '',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $files = glob('./task/*.php', GLOB_BRACE);

        foreach ($files as $file) {
            foreach (self::TABLES as $table) {
                if (!str_contains((string) $file, $table)) {
                    continue;
                }

                $array = [
                    'name' => null,
                    'comment' => null,
                    'fields' => null,
                ];

                $content = file_get_contents($file);
                $onlyNeedContent = getStringBetween($content, 'up()', 'down()');

                $lines = explode(PHP_EOL, $onlyNeedContent);

                foreach ($lines as $line) {
                    if (str_contains($line, '$table->')) {
                        if (str_contains($line, '$table->increments(\'id\');')) {
                            $array['fields'][] = self::PRIMARY_KEY;
                        } elseif (str_contains($line, '$table->timestamps();')) {
                            continue;
                        } elseif (preg_match(
                            '/\$table->(.*?)\(\'(.*?)\', (.*?)\).*?comment\(\'(.*?)\'\);/',
                            $line,
                            $matches
                        )) {
                            $type = $this->switch($matches[1]);
                            if ($type === '') {
                                exit("没有{$type}类型");
                            }

                            $array['fields'][] = [
                                'id' => $matches[2],
                                'comment' => $matches[4],
                                'type' => "$type($matches[3])",
                                'nullable' => str_contains($line, '->nullable()') ? 'TRUE' : 'FALSE',
                                'index' => '',
                            ];
                        } else {
                            exit("表：{$array['name']}，匹配字段失败：${line}");
                        }
                    } elseif (preg_match("/create\('(.*?)'/", $line, $matches)) {
                        $array['name'] = $matches['1'];
                    } elseif (str_contains($line, 'DB::statement')) {
                        if (preg_match(
                            '/DB::statement\("ALTER TABLE `'.$array['name'].'` comment \'(.*?)\'"\);/',
                            $line,
                            $matches
                        )) {
                            $array['comment'] = $matches[1];
                        }
                    }
                }

//        表名称,company_table_records,,,,,
//        表注释,企业相关表操作记录,,,,,
//        序号,字段名,备注,数据类型,是否为空,索引,备注
//        1,id,ID,int(11),FALSE,主键,
//        2,table_name,表名称,varchar(50),FALSE,,
//        3,user_code,用户标识符,varchar(50),FALSE,,
                echo "表名称,{$array['name']},,,,".PHP_EOL;
                echo "表注释,{$array['comment']},,,,".PHP_EOL;
                echo '序号,字段名,备注,数据类型,是否为空,索引';

                $no = 1;
                foreach ($array['fields'] as $v) {
                    $this->line(implode(',', [$no, $v['id'], $v['comment'], $v['type'], $v['nullable'], $v['index']]));
                    $no++;
                }
            }
        }
    }

    /**
     * Laravel 迁移，字段类型转 MySQL
     *
     * @param  string  $type  字段类型
     */
    public function switch(string $type): string
    {
        $types = [
            'string' => 'varchar',
            'text' => 'text',
        ];

        return $types[$type] ?? '';
    }
}

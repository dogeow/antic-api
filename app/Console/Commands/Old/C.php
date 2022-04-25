<?php

declare(strict_types=1);

namespace App\Console\Commands\Old;

use Illuminate\Console\Command;
use function App\Console\Commands\str_contains;
use const App\Console\Commands\PHP_EOL;

class C extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'c';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $needs = [
            'xzxkxxj',
            'xzxkxxx',
            'xzcfxxx',
            'spkjxx',
            'zlxxbhgsp',
            'xzcfxxj',
            'ssjbxx',
            'qyysxxes',
            'rcjgs',
            'gsgdxxes',
            'gskydjxxes',
            'gszxdjxxes',
            'lhdjs',
            'spjyxkzxxes',
            'qybgdjxxes',
            'qyzycyxxes',
            'ssjygks',
            'zdjksbs',
            'jybhgwts',
            'sydjblqks',
        ];

        $files = glob('./task/*.php', GLOB_BRACE);

        foreach ($files as $file) {
            foreach ($needs as $need) {
                if (str_contains($file, $need) === false) {
                    continue;
                }

                $migrateString = file_get_contents($file);
                $start = strpos($migrateString, 'up()');
                $end = strpos($migrateString, 'down()');

                $migrateSafeString = substr($migrateString, $start, $end - $start);

                $migrate = explode(PHP_EOL, $migrateSafeString);

                $array = [
                    'name' => null,
                    'comment' => null,
                    'fields' => null,
                ];

                foreach ($migrate as $line) {
                    if (str_contains($line, '$table->')) {
                        if (str_contains($line, '$table->increments(\'id\');')) {
                            $array['fields'][] = [
                                'id' => 'id',
                                'name' => '备注',
                                'type' => 'int(11)',
                                'nullable' => 'FALSE',
                                'index' => '主键',
                                'comment' => '',
                            ];
                        } elseif (str_contains($line, '$table->timestamps();')) {
                            continue;
                        } else {
                            if (preg_match(
                                '/\$table->(.*?)\(\'(.*?)\', (.*?)\).*?comment\(\'(.*?)\'\);/',
                                $line,
                                $matches
                            )) {
                                $array['fields'][] = [
                                    'id' => $matches[2],
                                    'comment' => $matches[4],
                                    'type' => $this->switch($matches[1])."({$matches[3]})",
                                    'nullable' => str_contains($line, '->nullable()') ? 'TRUE' : 'FALSE',
                                    'index' => '',
                                ];
                            } else {
                                exit("表：{$array['name']}，匹配字段失败：${line}");
                            }
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
                    echo "{$no},{$v['id']},{$v['comment']},{$v['type']},{$v['nullable']},{$v['index']}".PHP_EOL;
                    $no++;
                }
            }
        }
    }

    public function switch($type)
    {
        $types = [
            'string' => 'varchar',
            'text' => 'text',
        ];

        if (isset($types[$type])) {
            return $types[$type];
        }

        exit('没有'.$type.'类型');
    }
}

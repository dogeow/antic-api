<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PHP80Migration' => true,
    'not_operator_with_successor_space' => true, // ! 运算带有空格，比如「if (! $var)」
    'ordered_imports' => [ // use 排序
        'sort_algorithm' => 'alpha',
    ],
    'single_line_comment_spacing' => true, // 单行注释，添加前后空格
    'class_attributes_separation' => [
        'elements' => [
            'const' => 'one',
            'method' => 'one',
            'property' => 'one',
        ],
    ],
];

$finder = Finder::create()
    ->in([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/resources',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);

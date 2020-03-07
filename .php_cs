<?php

$excluded_folders = [
    'bootstrap/cache',
    'node_modules',
    'storage',
    'vendor'
];

$finder = PhpCsFixer\Finder::create()
    ->exclude($excluded_folders)
    ->name('*.php')
    ->notName('*.blade.php')
    ->notName('AcceptanceTester.php')
    ->notName('FunctionalTester.php')
    ->notName('UnitTester.php')
    ->in(__DIR__)
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);
;

return PhpCsFixer\Config::create()
    ->setRules(array(
        '@Laravel' => true,
        '@Laravel:risky' => true,
        'phpdoc_summary' => false,
        'array_syntax' => ['syntax' => 'short'],
        'linebreak_after_opening_tag' => true,
        'not_operator_with_successor_space' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,
    ))
    ->setFinder($finder)
;

<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true)
    ->exclude([
        'dev-tools/phpstan',
        'tests/Fixtures',
        'src/Infrastructure/Migrations',
    ])->in(__DIR__)
;

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'single_line_empty_body' => true,
        'concat_space' => true,
        'array_syntax' => ['syntax' => 'short'],
        'array_indentation' => true,
        'global_namespace_import' => [
            'import_constants' => true,
            'import_functions' => true,
            'import_classes' => true,
        ],
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_superfluous_phpdoc_tags' => ['allow_mixed' => true],
        'no_unused_imports' => true,
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_to_comment' => false,
        'self_static_accessor' => true,
        'static_lambda' => true,
        'strict_param' => true,
        '@PHPUnit100Migration:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'general_phpdoc_annotation_remove' => ['annotations' => ['expectedDeprecation']],
        // 'header_comment' => ['header' => $header],
        'modernize_strpos' => true, // needs PHP 8+ or polyfill
        'no_useless_concat_operator' => false, // TODO switch back on when the `src/Console/Application.php` no longer needs
        '@PHP82Migration' => true,
        '@PHP80Migration:risky' => true,
    ])
    ->setFinder($finder)
;

return $config;

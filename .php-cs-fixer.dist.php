<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('tests')
    ->notPath('app/Console/Commands/Playground.php')
    ->notPath('.php-cs-fixer.dist.php')
    ->in(__DIR__ . '/app');

$config = new PhpCsFixer\Config();

return $config->setRules([
    //array
    "array_syntax"                                => ['syntax' => 'short'],
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_trailing_comma_in_singleline_array'       => true,
    'no_whitespace_before_comma_in_array'         => true,
    'normalize_index_brace'                       => true,
    // 'trailing_comma_in_multiline_array'           => true,
    'trim_array_spaces'                           => true,
    'whitespace_after_comma_in_array'             => true,
    'array_indentation'                           => true,
    //comments
    'align_multiline_comment'                     => false,
    //operators
    'binary_operator_spaces'                      => [
        'operators' => [
            '='  => 'align',
            '+=' => 'align',
            '.=' => 'align',
            '*=' => 'align',
            '=>' => 'align',
        ],
    ],
    //blank lines
    'blank_line_after_namespace'                  => true,
    'blank_line_after_opening_tag'                => false,
    'blank_line_before_statement'                 => [
        'statements' => [
            'break',
            'continue',
            'declare',
            'return',
            'throw',
            'try'
        ]
    ],
    'braces'                                      => [
        'allow_single_line_closure'                   => false,
        'position_after_anonymous_constructs'         => 'same',
        'position_after_control_structures'           => 'same',
        'position_after_functions_and_oop_constructs' => 'next',
    ],
    'cast_spaces'                                 => ['space' => 'none'],
    'class_attributes_separation'                 => [
        'elements' => [
            'method'   => 'one',
            'property' => 'one'
        ],
    ],
    'no_unused_imports'                           => true,
    'class_keyword_remove'                        => false,
    'combine_consecutive_issets'                  => false,
    'combine_consecutive_unsets'                  => false,
    'combine_nested_dirname'                      => false,
    'comment_to_phpdoc'                           => false,
    'compact_nullable_typehint'                   => false,
    'concat_space'                                => ['spacing' => 'one'],
    'constant_case'                               => ['case' => 'lower'],
    'date_time_immutable'                         => false,
    'declare_equal_normalize'                     => [
        'space' => 'single',
    ],
    'declare_strict_types'                        => false,
    'dir_constant'                                => false,
    'doctrine_annotation_array_assignment'        => false,
    'doctrine_annotation_braces'                  => false,
    'doctrine_annotation_indentation'             => [
        'ignored_tags'       => [],
        'indent_mixed_lines' => true,
    ],
    'doctrine_annotation_spaces'                  => [
        'after_argument_assignments'     => false,
        'after_array_assignments_colon'  => false,
        'after_array_assignments_equals' => false,
    ],
    'elseif'                                      => false,
    'encoding'                                    => true,
    'indentation_type'                            => true,
    'no_useless_else'                             => true,
    'no_useless_return'                           => true,
    'ordered_imports'                             => true,
    'single_quote'                                => false,
    'ternary_operator_spaces'                     => true,
    'no_extra_blank_lines'                        => true,
    'multiline_whitespace_before_semicolons'      => true,
    'no_singleline_whitespace_before_semicolons'  => true,
    'no_spaces_around_offset'                     => true,
    'ternary_to_null_coalescing'                  => true,
    'unary_operator_spaces'                       => true,
])
    ->setRiskyAllowed(false)
    ->setIndent("    ")
    ->setFinder($finder);

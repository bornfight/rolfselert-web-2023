<?php

/* 
    This file is custom PHP CS Fixer. 
    It will format your code by Woredpress coding style rules. https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/
    Put this file in root of your Wordpress project.
    Install VS Code exstension https://github.com/junstyle/vscode-php-cs-fixer.
    Execute Code Format using php-cs-fixer.
*/

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\Tokenizer\CT;

/**
 * The Fixer Trait.
 */
trait FixerName {

    public function getName(): string {
        $name = parent::getName();

        return 'WeDevs/' . $name;
    }
}



/**
 * There must be a space inside the parenthesis.
 *
 * @author Tareq Hasan <tareq@wedevs.com>
 */
final class SpaceInsideParenthesisFixer extends AbstractFixer {

    use FixerName;

    private $singleLineWhitespaceOptions = " \t";

    /**
     * {@inheritdoc}
     */
    public function getDefinition(): FixerDefinitionInterface {
        return new FixerDefinition(
            'There MUST be a space after the opening parenthesis and a space before the closing parenthesis.',
            [
                new CodeSample(
                    '<?php

                        class Foo
                        {
                            public static function bar($baz , $foo)
                            {
                                return false;
                            }
                        }

                        function  foo( $bar, $baz )
                        {
                            return false;
                        }
                    '
                ),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isCandidate( Tokens $tokens ): bool {
        return $tokens->isTokenKindFound( '(' );
    }

    /**
     * {@inheritdoc}
     */
    protected function applyFix( SplFileInfo $file, Tokens $tokens ): void {
        foreach ( $tokens as $index => $token ) {
            if ( ! $token->equals( '(' ) ) {
                continue;
            }

            // don't process if the next token is `)`
            $nextMeaningfulTokenIndex = $tokens->getNextMeaningfulToken( $index );

            if ( ')' === $tokens[$nextMeaningfulTokenIndex]->getContent() ) {
                continue;
            }

            $endParenthesisIndex = $tokens->findBlockEnd( Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $index );

            $afterParenthesisIndex = $tokens->getNextNonWhitespace( $endParenthesisIndex );
            $afterParenthesisToken = $tokens[$afterParenthesisIndex];

            if ( $afterParenthesisToken->isGivenKind( CT::T_USE_LAMBDA ) ) {
                $useStartParenthesisIndex = $tokens->getNextTokenOfKind( $afterParenthesisIndex, ['('] );
                $useEndParenthesisIndex   = $tokens->findBlockEnd( Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $useStartParenthesisIndex );

                // add single-line edge whitespaces inside use parentheses
                $this->fixParenthesisInnerEdge( $tokens, $useStartParenthesisIndex, $useEndParenthesisIndex );
            }

            // add single-line edge whitespaces inside parameters list parentheses
            $this->fixParenthesisInnerEdge( $tokens, $index, $endParenthesisIndex );
        }
    }

    private function fixParenthesisInnerEdge( Tokens $tokens, $start, $end ): void {
        // add single-line whitespace before )
        if ( ! $tokens[$end - 1]->isWhitespace( $this->singleLineWhitespaceOptions ) && ! str_contains( $tokens[$end - 1]->getContent(), "\n" ) ) {
            $tokens->ensureWhitespaceAtIndex( $end, 0, ' ' );
        }

        // add single-line whitespace after (
        if ( ! $tokens[$start + 1]->isWhitespace( $this->singleLineWhitespaceOptions ) && ! str_contains( $tokens[$start + 1]->getContent(), "\n" ) ) {
            $tokens->ensureWhitespaceAtIndex( $start, 1, ' ' );
        }
    }
}


/**
 * There must be a space inside array index square brackets.
 *
 * @author Luka Uzel <luka.uzel@gmail.com>
 */
final class SpaceInsideSquareBracesFixer extends AbstractFixer {

    use FixerName;

    private $singleLineWhitespaceOptions = " \t";

    /**
     * {@inheritdoc}
     */
    public function getDefinition(): FixerDefinitionInterface {
        return new FixerDefinition(
            'There MUST be a space inside array index brackets if index is variable.',
            [
                new CodeSample(
                    '<?php

                    $index = 2;

                    $arr                       = array();
                    $arr["0"]                  = "one";
                    $arr["1"]                  = "two";
                    $arr[ $index ]             = "three";
                    '
                ),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isCandidate( Tokens $tokens ): bool {
        return ( $tokens->isTokenKindFound( '[' ) ); 
    }

    /**
     * {@inheritdoc}
     */
    protected function applyFix( SplFileInfo $file, Tokens $tokens ): void {

        foreach ( $tokens as $index => $token ) {

            
            if ( ! $token->equals( '[' ) ) {
                continue;
            }

            // don't process if the next token is `]`
            $nextMeaningfulTokenIndex = $tokens->getNextMeaningfulToken( $index );

            if ( ']' === $tokens[$nextMeaningfulTokenIndex]->getContent() ) {
                continue;
            } 

            $nextMeaningfulTokenIndex = $tokens->getNextNonWhitespace( $index );
            $nextToken = $tokens[$nextMeaningfulTokenIndex];

            $endParenthesisIndex = $tokens->findBlockEnd( Tokens::BLOCK_TYPE_INDEX_SQUARE_BRACE, $index );
            
            if ( $nextToken->getName() == 'T_VARIABLE' ) {

                if ( ! $tokens[$endParenthesisIndex - 1]->isWhitespace( $this->singleLineWhitespaceOptions ) ) {
                    $tokens->ensureWhitespaceAtIndex( $endParenthesisIndex, 0, ' ' );
                }

                if ( ! $tokens[$index + 1]->isWhitespace( $this->singleLineWhitespaceOptions ) ) {
                    $tokens->ensureWhitespaceAtIndex( $index, 1, ' ' );
                }

            } else if( $nextToken->getName() == 'T_CONSTANT_ENCAPSED_STRING' ) {

                if ( $tokens[$endParenthesisIndex - 1]->isWhitespace( $this->singleLineWhitespaceOptions ) ) {
                    $tokens->removeLeadingWhitespace($endParenthesisIndex, ' ');
                }

                if ( $tokens[$index + 1]->isWhitespace( $this->singleLineWhitespaceOptions ) ) {
                    $tokens->removeTrailingWhitespace($index, ' ');
                }

            }


        }
    }

}

/**
 * There must be a space after class definition.
 *
 * @author Tareq Hasan <tareq@wedevs.com>
 */
final class BlankLineAfterClassOpeningFixer extends AbstractFixer implements WhitespacesAwareFixerInterface {

    use FixerName;

    /**
     * {@inheritdoc}
     */
    public function getDefinition(): FixerDefinitionInterface {
        return new FixerDefinition(
            'There should be one empty line after class opening brace.',
            [
                new CodeSample(
                    '<?php
                    final class Sample {

                        protected function foo() {
                        }
                    }
                    '
                ),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isCandidate( Tokens $tokens ): bool {
        return $tokens->isAnyTokenKindsFound( Token::getClassyTokenKinds() );
    }

    /**
     * {@inheritdoc}
     */
    protected function applyFix( SplFileInfo $file, Tokens $tokens ): void {
        foreach ( $tokens as $index => $token ) {
            if ( ! $token->isClassy() ) {
                continue;
            }

            $startBraceIndex = $tokens->getNextTokenOfKind( $index, ['{'] );

            if ( ! $tokens[$startBraceIndex + 1]->isWhitespace() ) {
                continue;
            }

            $this->fixWhitespace( $tokens, $startBraceIndex + 1 );
        }
    }

    /**
     * Cleanup a whitespace token.
     *
     * @param int $index
     */
    private function fixWhitespace( Tokens $tokens, $index ): void {
        $content = $tokens[$index]->getContent();

        // there should be two new lines
        if ( 2 !== substr_count( $content, "\n" ) ) {
            $ending = $this->whitespacesConfig->getLineEnding();

            $emptyLines = $ending . $ending;
            $indent     = 1 === Preg::match( '/^.*\R( *)$/s', $content, $matches ) ? $matches[1] : '';

            $tokens[$index] = new Token( [T_WHITESPACE, $emptyLines . $indent] );
        }
    }
}



/**
 * The fixer utility class.
 * @author Tareq Hasan <tareq@wedevs.com>
 * @author Luka Uzel <luka.uzel@gmail.com>
 */
class Fixer {

    public static function rules() {
        return [
            '@PSR2'                   => false,
            'indentation_type'        => true,
            'align_multiline_comment' => true,
            'array_syntax'            => ['syntax' => 'long'],
            'binary_operator_spaces'  => [
                'operators' => ['=' => 'align_single_space', '=>' => 'align_single_space'],
            ],
            'blank_line_after_opening_tag' => true,
            'blank_line_before_statement'  => [
                'statements' => ['return', 'try', 'while', 'for', 'foreach', 'do', 'case'],
            ],
            'no_multiple_statements_per_line' => true,
            'braces' => [
            //     'position_after_functions_and_oop_constructs' => 'same',
            //     'allow_single_line_closure'                   => false,
            ],
            'cast_spaces' => ['space' => 'single'],
            //'class_attributes_separation' => ['elements' => ['method', 'const', 'property']],
            'class_definition'                        => ['single_line' => true],
            'concat_space'                            => ['spacing' => 'one'],
            'constant_case'                           => ['case' => 'lower'],
            'declare_equal_normalize'                 => ['space' => 'single'],
            'dir_constant'                            => true,
            'elseif'                                  => true,
            'full_opening_tag'                        => true,
            'fully_qualified_strict_types'            => true,
            'function_declaration'                    => true,
            'trim_array_spaces'                       => false, // Arrays should be formatted like function/method arguments, without leading or trailing single line space.
            'normalize_index_brace'                   => true, // Array index should always be written by using square braces.
            'whitespace_after_comma_in_array'         => true, // In array declaration, there MUST be a whitespace after each comma.
            'WeDevs/space_inside_parenthesis'         => true, // SpaceInsideParenthesisFixer
            'WeDevs/space_inside_square_braces'       => true, // SpaceInsideSquareBracesFixer
            'WeDevs/blank_line_after_class_opening'   => true, // BlankLineAfterClassOpeningFixer
            'function_typehint_space'                 => true,
            'global_namespace_import'                 => ['import_classes' => true],
            'include'                                 => true,
            'line_ending'                             => true,
            'list_syntax'                             => ['syntax' => 'long'],
            'lowercase_cast'                          => true,
            'lowercase_keywords'                      => true,
            'lowercase_static_reference'              => true,
            'magic_constant_casing'                   => true,
            'magic_method_casing'                     => true,
            'method_argument_space'                   => true,
            'native_function_casing'                  => true,
            'method_chaining_indentation'             => true,
            'native_function_type_declaration_casing' => true,
            'new_with_braces'                         => true,
            'no_alternative_syntax'                   => true,
            'no_blank_lines_after_class_opening'      => false,
            'no_blank_lines_after_phpdoc'             => true,
            'no_empty_comment'                        => true,
            'no_empty_phpdoc'                         => true,
            'no_empty_statement'                      => true,
            'no_extra_blank_lines'                    => [
                'tokens' => [
                    'extra',
                    'parenthesis_brace_block',
                    'square_brace_block',
                    'throw',
                    'use',
                ]
            ],
            'explicit_string_variable'                    => true,
            'explicit_indirect_variable'                  => true,
            'no_leading_import_slash'                     => true,
            'no_leading_namespace_whitespace'             => true,
            'no_mixed_echo_print'                         => true,
            'no_multiline_whitespace_around_double_arrow' => true,
            'no_short_bool_cast'                          => true,
            'echo_tag_syntax'                             => ['format' => 'long'],
            'no_singleline_whitespace_before_semicolons'  => true,
            'no_spaces_around_offset'                     => ['positions' => ['outside']],
            'no_spaces_inside_parenthesis'                => false,
            'no_superfluous_phpdoc_tags'                  => ['allow_mixed' => true, 'allow_unused_params' => true],
            // 'no_trailing_comma_in_singleline'              => true, // no_trailing_comma_in_list_call
            'no_trailing_whitespace'                      => false,
            'no_unneeded_control_parentheses'             => true,
            'no_unneeded_curly_braces'                    => true,
            'no_unneeded_final_method'                    => true,
            'no_unused_imports'                           => true,
            'no_whitespace_before_comma_in_array'         => true,
            'no_whitespace_in_blank_line'                 => true,
            'object_operator_without_whitespace'          => true,
            'ordered_imports'                             => true,
            'php_unit_fqcn_annotation'                    => true,
            'phpdoc_align'                                => [
                'align' => 'vertical',
                'tags'  => [
                    'method',
                    'param',
                    'property',
                    'return',
                    'throws',
                    'type',
                    'var',
                ],
            ],
            'phpdoc_annotation_without_dot' => true,
            'phpdoc_indent'                 => true,
            'general_phpdoc_tag_rename'     => [
                'fix_annotation' => true,
                'fix_inline'     => true,
            ],
            'phpdoc_no_access'                              => true,
            'phpdoc_no_alias_tag'                           => true,
            'phpdoc_no_package'                             => true,
            'phpdoc_no_useless_inheritdoc'                  => true,
            'phpdoc_return_self_reference'                  => true,
            'phpdoc_scalar'                                 => true,
            'phpdoc_separation'                             => true,
            'phpdoc_single_line_var_spacing'                => true,
            'phpdoc_to_comment'                             => true,
            'phpdoc_trim'                                   => true,
            'phpdoc_trim_consecutive_blank_line_separation' => true,
            'phpdoc_types'                                  => true,
            'phpdoc_types_order'                            => [
                'null_adjustment' => 'always_last',
                'sort_algorithm'  => 'none',
            ],
            'phpdoc_var_without_name'            => true,
            'return_type_declaration'            => true,
            'semicolon_after_instruction'        => true,
            'short_scalar_cast'                  => true,
            'single_blank_line_before_namespace' => true,
            'single_class_element_per_statement' => true,
            'single_line_comment_style'          => [
                'comment_types' => ['hash'],
            ],
            'single_line_throw'                 => true,
            'single_quote'                      => true,
            'single_trait_insert_per_statement' => true,
            'space_after_semicolon'             => [
                'remove_in_empty_for_expressions' => true,
            ],
            'standardize_increment'       => true,
            'standardize_not_equals'      => true,
            'ternary_operator_spaces'     => true,
            'trailing_comma_in_multiline' => [
                'elements' => ['arrays'],
            ],
            'not_operator_with_space'           => true,
            'types_spaces'                      => true,
        ];
    }
}

$finder = PhpCsFixer\Finder::create()
    ->ignoreDotFiles(true)
	->exclude('vendor')
	->exclude('node_modules')
	->exclude('plugins')
	->exclude('static')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
	->registerCustomFixers([
		new SpaceInsideParenthesisFixer(),
        new SpaceInsideSquareBracesFixer(),
		new BlankLineAfterClassOpeningFixer()
    ])
	->setRules( Fixer::rules() )
    ->setFinder($finder)
;
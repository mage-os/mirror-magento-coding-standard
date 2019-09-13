<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\GraphQL;

use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Defines an abstract base class for GraphQL sniffs.
 */
abstract class AbstractGraphQLSniff implements Sniff
{
    /**
     * Defines the tokenizers that this sniff is using.
     *
     * @var array
     */
    public $supportedTokenizers = ['GRAPHQL'];

    /**
     * Returns whether <var>$name</var> starts with a lower case character and is written in camel case.
     *
     * @param string $name
     * @return bool
     */
    protected function isCamelCase($name)
    {
        return (preg_match('/^[a-z][a-zA-Z0-9]+$/', $name) !== 0);
    }

    /**
     * Returns whether <var>$name</var> is specified in snake case (either all lower case or all upper case).
     *
     * @param string $name
     * @param bool $upperCase If set to <kbd>true</kbd> checks for all upper case, otherwise all lower case
     * @return bool
     */
    protected function isSnakeCase($name, $upperCase = false)
    {
        $pattern = $upperCase ? '/^[A-Z][A-Z0-9_]*$/' : '/^[a-z][a-z0-9_]*$/';
        return preg_match($pattern, $name);
    }

    /**
     * Searches for the first token that has <var>$tokenCode</var> in <var>$tokens</var> from position
     * <var>$startPointer</var> (excluded).
     *
     * @param mixed $tokenCode
     * @param array $tokens
     * @param int $startPointer
     * @return bool|int If token was found, returns its pointer, <kbd>false</kbd> otherwise
     */
    protected function seekToken($tokenCode, array $tokens, $startPointer = 0)
    {
        $numTokens = count($tokens);

        for ($i = $startPointer + 1; $i < $numTokens; ++$i) {
            if ($tokens[$i]['code'] === $tokenCode) {
                return $i;
            }
        }

        //if we came here we could not find the requested token
        return false;
    }
}

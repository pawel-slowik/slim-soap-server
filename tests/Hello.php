<?php

declare(strict_types=1);

namespace Test;

/**
 * Example service.
 *
 * This class is used for reflection testing.
 */
class Hello
{
    const FOO = "foo";

    /**
     * Short method description.
     *
     * Long method description.
     *
     * @param string $subject parameter description
     *
     * @return string return value description
     */
    public function greet(string $subject): string
    {
        return "Hello, {$subject}!";
    }

    public function greetNoDocBlock(string $subject): string
    {
        return "Hello, {$subject}!";
    }

    /**
     * Short method description.
     *
     * Long method description.
     */
    public function greetIncompleteDocBlock(string $subject): string
    {
        return "Hello, {$subject}!";
    }

    /**
     * Short method description.
     *
     * Long method description.
     *
     * @param string $subject parameter description
     *
     * @return string return value description
     */
    public function greetWithDefaultValue(string $subject = "world"): string
    {
        return "Hello, {$subject}!";
    }

    /**
     * Short method description.
     *
     * Long method description.
     *
     * @param string $subject parameter description
     *
     * @return string return value description
     */
    public function greetWithDefaultConstantValue(string $subject = self::FOO): string
    {
        return "Hello, {$subject}!";
    }

    /**
     * Short method description.
     *
     * Long method description.
     *
     * @param string $foo first parameter description
     * @param string $bar second parameter description
     *
     * @return string return value description
     */
    public function methodWithTwoParameters(string $foo, string $bar): string
    {
        return "Hello, {$foo} and {$bar}!";
    }
}

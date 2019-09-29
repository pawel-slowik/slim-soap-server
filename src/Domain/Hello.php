<?php

declare(strict_types=1);

namespace Domain;

/**
 * Example service.
 */
class Hello
{

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
        return "Hello, $subject!";
    }
}

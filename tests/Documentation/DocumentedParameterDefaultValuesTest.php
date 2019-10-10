<?php

declare(strict_types=1);

namespace Test\Documentation;

use Application\Models\DocumentedParameter;

class DocumentedParameterDefaultValuesTest extends DocumentedTestBase
{
    protected $parameterWithDefaultValue;

    protected $parameterWithDefaultConstantValue;

    protected function setUp(): void
    {
        $this->parameterWithDefaultValue = $this->getReflectedParameter(
            Hello::class,
            "greetWithDefaultValue",
            "subject"
        );
        $this->parameterWithDefaultConstantValue = $this->getReflectedParameter(
            Hello::class,
            "greetWithDefaultConstantValue",
            "subject"
        );
    }

    public function testWithDefaultValue(): void
    {
        $documentedParameter = new DocumentedParameter($this->parameterWithDefaultValue);
        $this->assertSame("'world'", $documentedParameter->defaultValue);
    }

    public function testWithDefaultConstantValue(): void
    {
        $documentedParameter = new DocumentedParameter($this->parameterWithDefaultConstantValue);
        $this->assertSame("self::FOO", $documentedParameter->defaultValue);
    }
}

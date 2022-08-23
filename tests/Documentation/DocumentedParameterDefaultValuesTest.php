<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedParameter;
use Test\Hello;

class DocumentedParameterDefaultValuesTest extends DocumentedTestBase
{
    private DocumentedParameter $documentedParameterWithDefaultValue;

    private DocumentedParameter $documentedParameterWithDefaultConstantValue;

    protected function setUp(): void
    {
        $this->documentedParameterWithDefaultValue = new DocumentedParameter(
            $this->getReflectedParameter(
                Hello::class,
                "greetWithDefaultValue",
                "subject"
            )
        );
        $this->documentedParameterWithDefaultConstantValue = new DocumentedParameter(
            $this->getReflectedParameter(
                Hello::class,
                "greetWithDefaultConstantValue",
                "subject"
            )
        );
    }

    public function testWithDefaultValue(): void
    {
        $this->assertSame(
            "'world'",
            $this->documentedParameterWithDefaultValue->defaultValue
        );
    }

    public function testWithDefaultConstantValue(): void
    {
        $this->assertSame(
            "self::FOO",
            $this->documentedParameterWithDefaultConstantValue->defaultValue
        );
    }
}

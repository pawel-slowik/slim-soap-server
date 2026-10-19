<?php

declare(strict_types=1);

namespace Test\Unit\Documentation;

use AutoSoapServer\Documentation\DocumentedParameter;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;
use Test\ReflectionHelper;

class DocumentedParameterDefaultValuesTest extends TestCase
{
    private DocumentedParameter $documentedParameterWithDefaultValue;

    private DocumentedParameter $documentedParameterWithDefaultConstantValue;

    protected function setUp(): void
    {
        $this->documentedParameterWithDefaultValue = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(
                Hello::class,
                "greetWithDefaultValue",
                "subject"
            )
        );
        $this->documentedParameterWithDefaultConstantValue = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(
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

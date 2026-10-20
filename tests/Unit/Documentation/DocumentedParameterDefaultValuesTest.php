<?php

declare(strict_types=1);

namespace Test\Unit\Documentation;

use AutoSoapServer\Documentation\DocumentedParameter;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;
use Test\ReflectionHelper;

#[CoversClass(DocumentedParameter::class)]
class DocumentedParameterDefaultValuesTest extends TestCase
{
    public function testWithDefaultValue(): void
    {
        $documentedParameterWithDefaultValue = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(
                Hello::class,
                "greetWithDefaultValue",
                "subject"
            )
        );
        $this->assertSame(
            "'world'",
            $documentedParameterWithDefaultValue->defaultValue
        );
    }

    public function testWithDefaultConstantValue(): void
    {
        $documentedParameterWithDefaultConstantValue = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(
                Hello::class,
                "greetWithDefaultConstantValue",
                "subject"
            )
        );
        $this->assertSame(
            "self::FOO",
            $documentedParameterWithDefaultConstantValue->defaultValue
        );
    }
}

<?php

declare(strict_types=1);

namespace Test\Unit\Documentation;

use AutoSoapServer\Documentation\DocumentedParameter;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;
use Test\ReflectionHelper;

#[CoversClass(DocumentedParameter::class)]
class DocumentedParameterTest extends TestCase
{
    public function testName(): void
    {
        $documentedParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(Hello::class, "greet", "subject")
        );
        $this->assertSame(
            "subject",
            $documentedParameter->name
        );
    }

    public function testType(): void
    {
        $documentedParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(Hello::class, "greet", "subject")
        );
        $this->assertSame(
            "string",
            (string) $documentedParameter->type
        );
    }

    public function testDefaultValue(): void
    {
        $documentedParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(Hello::class, "greet", "subject")
        );
        $this->assertNull($documentedParameter->defaultValue);
    }

    public function testDescription(): void
    {
        $documentedParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(Hello::class, "greet", "subject")
        );
        $this->assertSame(
            "parameter description",
            $documentedParameter->description
        );
    }

    public function testIsNullable(): void
    {
        $documentedParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(Hello::class, "greet", "subject")
        );
        $this->assertFalse($documentedParameter->isNullable);
    }

    public function testIsOptional(): void
    {
        $documentedParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(Hello::class, "greet", "subject")
        );
        $this->assertFalse($documentedParameter->isOptional);
    }
}

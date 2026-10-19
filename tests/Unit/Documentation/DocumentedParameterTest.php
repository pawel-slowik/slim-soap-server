<?php

declare(strict_types=1);

namespace Test\Unit\Documentation;

use AutoSoapServer\Documentation\DocumentedParameter;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;
use Test\ReflectionHelper;

class DocumentedParameterTest extends TestCase
{
    private DocumentedParameter $documentedParameter;

    protected function setUp(): void
    {
        $this->documentedParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(Hello::class, "greet", "subject")
        );
    }

    public function testName(): void
    {
        $this->assertSame(
            "subject",
            $this->documentedParameter->name
        );
    }

    public function testType(): void
    {
        $this->assertSame(
            "string",
            (string) $this->documentedParameter->type
        );
    }

    public function testDefaultValue(): void
    {
        $this->assertNull($this->documentedParameter->defaultValue);
    }

    public function testDescription(): void
    {
        $this->assertSame(
            "parameter description",
            $this->documentedParameter->description
        );
    }

    public function testIsNullable(): void
    {
        $this->assertFalse($this->documentedParameter->isNullable);
    }

    public function testIsOptional(): void
    {
        $this->assertFalse($this->documentedParameter->isOptional);
    }
}

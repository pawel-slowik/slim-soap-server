<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedParameter;

use Test\Hello;

class DocumentedParameterTest extends DocumentedTestBase
{
    private DocumentedParameter $documentedParameter;

    protected function setUp(): void
    {
        $this->documentedParameter = new DocumentedParameter(
            $this->getReflectedParameter(Hello::class, "greet", "subject")
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

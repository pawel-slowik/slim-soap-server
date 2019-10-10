<?php

declare(strict_types=1);

namespace Test;

use Application\Models\DocumentedParameter;

class DocumentedParameterTest extends DocumentedTestBase
{
    protected $parameter;

    protected function setUp(): void
    {
        $this->parameter = $this->getReflectedParameter(Hello::class, "greet", "subject");
    }

    public function testName(): void
    {
        $documentedParameter = new DocumentedParameter($this->parameter);
        $this->assertSame("subject", $documentedParameter->name);
    }

    public function testType(): void
    {
        $documentedParameter = new DocumentedParameter($this->parameter);
        $this->assertSame("string", $documentedParameter->type);
    }

    public function testDefaultValue(): void
    {
        $documentedParameter = new DocumentedParameter($this->parameter);
        $this->assertNull($documentedParameter->defaultValue);
    }

    public function testDescription(): void
    {
        $documentedParameter = new DocumentedParameter($this->parameter);
        $this->assertSame("parameter description", $documentedParameter->description);
    }

    public function testIsNullable(): void
    {
        $documentedParameter = new DocumentedParameter($this->parameter);
        $this->assertFalse($documentedParameter->isNullable);
    }

    public function testIsOptional(): void
    {
        $documentedParameter = new DocumentedParameter($this->parameter);
        $this->assertFalse($documentedParameter->isOptional);
    }
}

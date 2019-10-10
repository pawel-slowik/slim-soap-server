<?php

declare(strict_types=1);

namespace Test\Documentation;

use Application\Models\DocumentedMethod;

class DocumentedMethodTest extends DocumentedTestBase
{
    protected $method;

    protected function setUp(): void
    {
        $this->method = $this->getReflectedMethod(Hello::class, "greet");
    }

    public function testName(): void
    {
        $documentedMethod = new DocumentedMethod($this->method);
        $this->assertSame("greet", $documentedMethod->name);
    }

    public function testShortDescription(): void
    {
        $documentedMethod = new DocumentedMethod($this->method);
        $this->assertSame("Short method description.", $documentedMethod->shortDescription);
    }

    public function testLongDescription(): void
    {
        $documentedMethod = new DocumentedMethod($this->method);
        $this->assertSame("Long method description.", $documentedMethod->longDescription);
    }

    public function testReturnType(): void
    {
        $documentedMethod = new DocumentedMethod($this->method);
        $this->assertSame("string", (string) $documentedMethod->returnType);
    }

    public function testReturnDescription(): void
    {
        $documentedMethod = new DocumentedMethod($this->method);
        $this->assertSame("return value description", $documentedMethod->returnDescription);
    }
}

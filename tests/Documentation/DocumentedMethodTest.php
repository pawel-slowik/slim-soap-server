<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedMethod;
use Test\Hello;

class DocumentedMethodTest extends DocumentedTestBase
{
    private DocumentedMethod $documentedMethod;

    protected function setUp(): void
    {
        $this->documentedMethod = DocumentedMethod::fromMethodReflection(
            $this->getReflectedMethod(Hello::class, "greet")
        );
    }

    public function testName(): void
    {
        $this->assertSame(
            "greet",
            $this->documentedMethod->name
        );
    }

    public function testShortDescription(): void
    {
        $this->assertSame(
            "Short method description.",
            $this->documentedMethod->shortDescription
        );
    }

    public function testLongDescription(): void
    {
        $this->assertSame(
            "Long method description.",
            $this->documentedMethod->longDescription
        );
    }

    public function testReturnType(): void
    {
        $this->assertSame(
            "string",
            (string) $this->documentedMethod->returnType
        );
    }

    public function testReturnDescription(): void
    {
        $this->assertSame(
            "return value description",
            $this->documentedMethod->returnDescription
        );
    }
}

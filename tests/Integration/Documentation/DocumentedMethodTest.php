<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\DocumentedMethod;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;
use Test\ReflectionHelper;

class DocumentedMethodTest extends TestCase
{
    public function testName(): void
    {
        $documentedMethod = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(Hello::class, "greet")
        );
        $this->assertSame(
            "greet",
            $documentedMethod->name
        );
    }

    public function testShortDescription(): void
    {
        $documentedMethod = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(Hello::class, "greet")
        );
        $this->assertSame(
            "Short method description.",
            $documentedMethod->shortDescription
        );
    }

    public function testLongDescription(): void
    {
        $documentedMethod = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(Hello::class, "greet")
        );
        $this->assertSame(
            "Long method description.",
            $documentedMethod->longDescription
        );
    }

    public function testReturnType(): void
    {
        $documentedMethod = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(Hello::class, "greet")
        );
        $this->assertSame(
            "string",
            (string) $documentedMethod->returnType
        );
    }

    public function testReturnDescription(): void
    {
        $documentedMethod = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(Hello::class, "greet")
        );
        $this->assertSame(
            "return value description",
            $documentedMethod->returnDescription
        );
    }
}

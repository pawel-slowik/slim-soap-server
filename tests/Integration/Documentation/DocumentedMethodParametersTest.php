<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\DocumentedMethod;
use AutoSoapServer\Documentation\DocumentedParameter;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;
use Test\ReflectionHelper;

class DocumentedMethodParametersTest extends TestCase
{
    public function testNumberOfParameters(): void
    {
        $documentedMethodWithTwoParameters = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(
                Hello::class,
                "methodWithTwoParameters"
            )
        );
        $this->assertCount(
            2,
            $documentedMethodWithTwoParameters->parameters
        );
    }

    public function testTypeOfParameters(): void
    {
        $documentedMethodWithTwoParameters = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(
                Hello::class,
                "methodWithTwoParameters"
            )
        );
        $this->assertContainsOnlyInstancesOf(
            DocumentedParameter::class,
            $documentedMethodWithTwoParameters->parameters
        );
    }

    public function testOrderOfParameters(): void
    {
        $documentedMethodWithTwoParameters = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(
                Hello::class,
                "methodWithTwoParameters"
            )
        );
        $this->assertSame(
            "foo",
            $documentedMethodWithTwoParameters->parameters[0]->name
        );
        $this->assertSame(
            "bar",
            $documentedMethodWithTwoParameters->parameters[1]->name
        );
    }
}

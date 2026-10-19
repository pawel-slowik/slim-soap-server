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
    private DocumentedMethod $documentedMethodWithTwoParameters;

    protected function setUp(): void
    {
        $this->documentedMethodWithTwoParameters = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(
                Hello::class,
                "methodWithTwoParameters"
            )
        );
    }

    public function testNumberOfParameters(): void
    {
        $this->assertCount(
            2,
            $this->documentedMethodWithTwoParameters->parameters
        );
    }

    public function testTypeOfParameters(): void
    {
        $this->assertContainsOnlyInstancesOf(
            DocumentedParameter::class,
            $this->documentedMethodWithTwoParameters->parameters
        );
    }

    public function testOrderOfParameters(): void
    {
        $this->assertSame(
            "foo",
            $this->documentedMethodWithTwoParameters->parameters[0]->name
        );
        $this->assertSame(
            "bar",
            $this->documentedMethodWithTwoParameters->parameters[1]->name
        );
    }
}

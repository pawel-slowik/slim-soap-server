<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedMethod;
use AutoSoapServer\Documentation\DocumentedParameter;
use Test\Hello;

class DocumentedMethodParametersTest extends DocumentedTestBase
{
    private DocumentedMethod $documentedMethodWithTwoParameters;

    protected function setUp(): void
    {
        $this->documentedMethodWithTwoParameters = new DocumentedMethod(
            $this->getReflectedMethod(
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

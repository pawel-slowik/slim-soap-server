<?php

declare(strict_types=1);

namespace Test\Documentation;

use Application\Models\DocumentedMethod;
use Application\Models\DocumentedParameter;

use Test\Hello;

class DocumentedMethodParametersTest extends DocumentedTestBase
{
    protected $methodWithTwoParameters;

    protected function setUp(): void
    {
        $this->methodWithTwoParameters = $this->getReflectedMethod(
            Hello::class,
            "methodWithTwoParameters"
        );
    }

    public function testNumberOfParameters(): void
    {
        $documentedMethod = new DocumentedMethod($this->methodWithTwoParameters);
        $this->assertCount(2, $documentedMethod->parameters);
    }

    public function testTypeOfParameters(): void
    {
        $documentedMethod = new DocumentedMethod($this->methodWithTwoParameters);
        $this->assertContainsOnlyInstancesOf(DocumentedParameter::class, $documentedMethod->parameters);
    }

    public function testOrderOfParameters(): void
    {
        $documentedMethod = new DocumentedMethod($this->methodWithTwoParameters);
        $this->assertSame("foo", $documentedMethod->parameters[0]->name);
        $this->assertSame("bar", $documentedMethod->parameters[1]->name);
    }
}

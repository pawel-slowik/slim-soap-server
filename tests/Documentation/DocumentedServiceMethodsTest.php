<?php

declare(strict_types=1);

namespace Test\Documentation;

use PHPUnit\Framework\TestCase;

use Zend\Code\Reflection\ClassReflection;

use AutoSoapServer\Documentation\DocumentedService;
use AutoSoapServer\Documentation\DocumentedMethod;

use Test\Hello;

class DocumentedServiceMethodsTest extends TestCase
{
    protected $documentedService;

    protected function setUp(): void
    {
        $this->documentedService = new DocumentedService(
            "test",
            new ClassReflection(Hello::class)
        );
    }

    public function testNumberOfMethods(): void
    {
        $this->assertCount(
            7,
            $this->documentedService->methods
        );
    }

    public function testTypeOfMethods(): void
    {
        $this->assertContainsOnlyInstancesOf(
            DocumentedMethod::class,
            $this->documentedService->methods
        );
    }
}

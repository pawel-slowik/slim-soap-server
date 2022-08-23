<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedMethod;
use AutoSoapServer\Documentation\DocumentedService;
use Laminas\Code\Reflection\ClassReflection;
use PHPUnit\Framework\TestCase;
use Test\Hello;

class DocumentedServiceMethodsTest extends TestCase
{
    private DocumentedService $documentedService;

    protected function setUp(): void
    {
        $this->documentedService = new DocumentedService(
            "test",
            new ClassReflection(Hello::class),
            []
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

<?php

declare(strict_types=1);

namespace Test\Documentation;

use PHPUnit\Framework\TestCase;

use Zend\Code\Reflection\ClassReflection;

use AutoSoapServer\Documentation\DocumentedService;
use AutoSoapServer\Documentation\DocumentedType;

use Test\Hello;

class DocumentedServiceTypesTest extends TestCase
{
    protected $documentedService;

    protected function setUp(): void
    {
        $this->documentedService = new DocumentedService(
            "test",
            new ClassReflection(Hello::class)
        );
    }

    public function testNumberOfTypes(): void
    {
        $this->assertCount(
            1,
            $this->documentedService->types
        );
    }

    public function testTypeOfTypes(): void
    {
        $this->assertContainsOnlyInstancesOf(
            DocumentedType::class,
            $this->documentedService->types
        );
    }
}

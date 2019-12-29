<?php

declare(strict_types=1);

namespace Test\Documentation;

use PHPUnit\Framework\TestCase;

use Zend\Code\Reflection\ClassReflection;

use AutoSoapServer\Documentation\DocumentedService;
use AutoSoapServer\Documentation\DocumentedType;
use AutoSoapServer\SoapService\SoapService;

use Test\Hello;

class DocumentedServiceTypesTest extends TestCase
{
    protected $documentedService;

    protected $documentedTypeNames;

    protected function setUp(): void
    {
        $this->documentedService = new DocumentedService(
            "test",
            new ClassReflection(Hello::class),
            (new SoapService(new Hello()))->discoverComplexTypes()
        );
        $this->documentedTypeNames = array_map(
            function ($type) {
                return $type->name;
            },
            $this->documentedService->types
        );
    }

    public function testNumberOfTypes(): void
    {
        $this->assertCount(
            2,
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

    public function testMethodParameterTypeIsDetected(): void
    {
        $this->assertContains(
            "Test\\Type",
            $this->documentedTypeNames
        );
    }

    public function testComplexTypePropertyTypeIsDetected(): void
    {
        $this->assertContains(
            "Test\\AnotherType",
            $this->documentedTypeNames
        );
    }
}

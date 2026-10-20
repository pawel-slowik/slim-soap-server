<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\DocumentedService;
use AutoSoapServer\Documentation\DocumentedType;
use AutoSoapServer\SoapService\ClassMapGenerator;
use AutoSoapServer\SoapService\ComplexTypesGenerator;
use AutoSoapServer\SoapService\SoapService;
use Laminas\Code\Reflection\ClassReflection;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;

class DocumentedServiceTypesTest extends TestCase
{
    private ClassReflection $clientClassReflection;

    private array $discoveredComplexTypes;

    protected function setUp(): void
    {
        $soapService = new SoapService(new ClassMapGenerator(), new ComplexTypesGenerator(), new Hello());
        $this->clientClassReflection = new ClassReflection(Hello::class);
        $this->discoveredComplexTypes = $soapService->discoverComplexTypes();
    }

    public function testNumberOfTypes(): void
    {
        $documentedService = DocumentedService::fromClassReflection(
            "test",
            $this->clientClassReflection,
            $this->discoveredComplexTypes,
        );
        $this->assertCount(
            2,
            $documentedService->types
        );
    }

    public function testTypeOfTypes(): void
    {
        $documentedService = DocumentedService::fromClassReflection(
            "test",
            $this->clientClassReflection,
            $this->discoveredComplexTypes,
        );
        $this->assertContainsOnlyInstancesOf(
            DocumentedType::class,
            $documentedService->types
        );
    }

    public function testMethodParameterTypeIsDetected(): void
    {
        $documentedService = DocumentedService::fromClassReflection(
            "test",
            $this->clientClassReflection,
            $this->discoveredComplexTypes,
        );
        $documentedTypeNames = array_map(
            fn (DocumentedType $type): string => $type->name,
            $documentedService->types
        );
        $this->assertContains(
            "Test\\Fixture\\Type",
            $documentedTypeNames
        );
    }

    public function testComplexTypePropertyTypeIsDetected(): void
    {
        $documentedService = DocumentedService::fromClassReflection(
            "test",
            $this->clientClassReflection,
            $this->discoveredComplexTypes,
        );
        $documentedTypeNames = array_map(
            fn (DocumentedType $type): string => $type->name,
            $documentedService->types
        );
        $this->assertContains(
            "Test\\Fixture\\AnotherType",
            $documentedTypeNames
        );
    }
}

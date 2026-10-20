<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\ComplexTypesGenerator;
use AutoSoapServer\Documentation\DocumentationGenerator;
use AutoSoapServer\Documentation\DocumentedService;
use AutoSoapServer\Documentation\DocumentedType;
use Laminas\Code\Reflection\ClassReflection;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;

class DocumentedServiceTypesTest extends TestCase
{
    private ClassReflection $clientClassReflection;

    private array $discoveredComplexTypes;

    protected function setUp(): void
    {
        $documentationGenerator = new DocumentationGenerator(new ComplexTypesGenerator());
        $this->clientClassReflection = new ClassReflection(Hello::class);
        $this->discoveredComplexTypes = $documentationGenerator->discoverComplexTypes(new Hello());
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

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
    private DocumentedService $documentedService;

    /** @var array<string, string> */
    private array $documentedTypeNames;

    protected function setUp(): void
    {
        $this->documentedService = DocumentedService::fromClassReflection(
            "test",
            new ClassReflection(Hello::class),
            new SoapService(
                new ClassMapGenerator(),
                new ComplexTypesGenerator(),
                new Hello(),
            )->discoverComplexTypes(),
        );
        $this->documentedTypeNames = array_map(
            fn (DocumentedType $type): string => $type->name,
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
            "Test\\Fixture\\Type",
            $this->documentedTypeNames
        );
    }

    public function testComplexTypePropertyTypeIsDetected(): void
    {
        $this->assertContains(
            "Test\\Fixture\\AnotherType",
            $this->documentedTypeNames
        );
    }
}

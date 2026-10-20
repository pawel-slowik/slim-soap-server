<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\ComplexTypesGenerator;
use AutoSoapServer\Documentation\DocumentationGenerator;
use AutoSoapServer\SoapService\SoapService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;

#[CoversClass(DocumentationGenerator::class)]
class DocumentationGeneratorTest extends TestCase
{
    private SoapService&Stub $soapService;

    private object $clientService;

    private DocumentationGenerator $generator;

    protected function setUp(): void
    {
        $this->soapService = $this->createStub(SoapService::class);
        $this->soapService->method("getName")->willReturn("service name");
        $this->soapService->method("getImplementation")->willReturn(new Hello());

        $this->clientService = new Hello();

        $this->generator = new DocumentationGenerator(new ComplexTypesGenerator());
    }

    public function testReturnedType(): void
    {
        $documentedService = $this->generator->createDocumentation($this->soapService);

        $this->assertNotEmpty($documentedService->name);
        $this->assertNotEmpty($documentedService->shortDescription);
        $this->assertNotEmpty($documentedService->longDescription);
        $this->assertNotEmpty($documentedService->methods);
        $this->assertNotEmpty($documentedService->types);
    }

    public function testNumberOfDetectedComplexTypes(): void
    {
        $types = $this->generator->discoverComplexTypes($this->clientService);
        $this->assertCount(2, $types);
    }

    public function testMethodParameterTypeIsDetected(): void
    {
        $types = $this->generator->discoverComplexTypes($this->clientService);
        $this->assertContains("\\Test\\Fixture\\Type", $types);
    }

    public function testComplexTypePropertyTypeIsDetected(): void
    {
        $types = $this->generator->discoverComplexTypes($this->clientService);
        $this->assertContains("\\Test\\Fixture\\AnotherType", $types);
    }
}

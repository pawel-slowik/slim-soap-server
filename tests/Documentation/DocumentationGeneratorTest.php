<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentationGenerator;
use AutoSoapServer\SoapService\SoapService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Test\Hello;

#[CoversClass(DocumentationGenerator::class)]
class DocumentationGeneratorTest extends TestCase
{
    private SoapService&Stub $soapService;

    private DocumentationGenerator $generator;

    protected function setUp(): void
    {
        $this->soapService = $this->createStub(SoapService::class);
        $this->soapService->method("getName")->willReturn("service name");
        $this->soapService->method("getImplementation")->willReturn(new Hello());
        $this->soapService->method("discoverComplexTypes")->willReturn(["\\Test\\Type"]);

        $this->generator = new DocumentationGenerator();
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
}

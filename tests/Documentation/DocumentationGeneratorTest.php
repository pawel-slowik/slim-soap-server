<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentationGenerator;
use AutoSoapServer\Documentation\DocumentedService;
use AutoSoapServer\SoapService\SoapService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Test\Hello;

#[CoversClass(DocumentationGenerator::class)]
class DocumentationGeneratorTest extends TestCase
{
    private SoapService $soapService;

    protected function setUp(): void
    {
        $this->soapService = new SoapService(new Hello());
    }

    public function testReturnedType(): void
    {
        $generator = new DocumentationGenerator();
        $documentedService = $generator->createDocumentation($this->soapService);
        $this->assertInstanceOf(DocumentedService::class, $documentedService);
    }
}

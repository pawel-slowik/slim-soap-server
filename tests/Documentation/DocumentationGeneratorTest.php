<?php

declare(strict_types=1);

namespace Test\Documentation;

use PHPUnit\Framework\TestCase;

use AutoSoapServer\Documentation\DocumentationGenerator;
use AutoSoapServer\Documentation\DocumentedService;
use AutoSoapServer\SoapService\SoapService;

use Test\Hello;

/**
 * @covers \AutoSoapServer\Documentation\DocumentationGenerator
 */
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

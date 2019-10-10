<?php

declare(strict_types=1);

namespace Test\Documentation;

use PHPUnit\Framework\TestCase;

use Application\Models\SoapService;
use Application\Models\DocumentationGenerator;
use Application\Models\DocumentedService;

use Test\Hello;

/**
 * @covers \Application\Models\DocumentationGenerator
 */
class DocumentationGeneratorTest extends TestCase
{
    protected $soapService;

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

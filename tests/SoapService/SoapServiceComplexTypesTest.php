<?php

declare(strict_types=1);

namespace Test\SoapService;

use PHPUnit\Framework\TestCase;

use AutoSoapServer\SoapService\SoapService;

use Test\Hello;

/**
 * @covers \AutoSoapServer\SoapService\SoapService
 */
class SoapServiceComplexTypesTest extends TestCase
{
    private SoapService $service;

    protected function setUp(): void
    {
        $this->service = new SoapService(new Hello());
    }

    public function testNumberOfDetectedComplexTypes(): void
    {
        $this->assertCount(
            2,
            $this->service->discoverComplexTypes()
        );
    }

    public function testMethodParameterTypeIsDetected(): void
    {
        $this->assertContains(
            "\\Test\\Type",
            $this->service->discoverComplexTypes(),
        );
    }

    public function testComplexTypePropertyTypeIsDetected(): void
    {
        $this->assertContains(
            "\\Test\\AnotherType",
            $this->service->discoverComplexTypes(),
        );
    }
}

<?php

declare(strict_types=1);

namespace Test\SoapService;

use PHPUnit\Framework\TestCase;

use AutoSoapServer\Models\SoapService;
use AutoSoapServer\Models\SoapServiceRegistry;
use AutoSoapServer\Models\SoapServiceRegistrationFailedException;
use AutoSoapServer\Models\SoapServiceNotFoundException;

/**
 * @covers \AutoSoapServer\Models\SoapServiceRegistry
 */
class SoapServiceRegistryTest extends TestCase
{
    protected $soapService;

    protected function setUp(): void
    {
        $this->soapService = new SoapService(new \stdClass());
    }

    public function testListEmpty(): void
    {
        $registry = new SoapServiceRegistry();
        $this->assertCount(0, $registry->listPaths());
    }

    public function testListAfterAdding(): void
    {
        $registry = new SoapServiceRegistry();
        $registry->addService("test", $this->soapService);
        $this->assertCount(1, $registry->listPaths());
    }

    public function testDuplicatePath(): void
    {
        $registry = new SoapServiceRegistry();
        $registry->addService("test", $this->soapService);
        $this->expectException(SoapServiceRegistrationFailedException::class);
        $registry->addService("test", $this->soapService);
    }

    public function testInvalidPath(): void
    {
        $registry = new SoapServiceRegistry();
        $registry->addService("test", $this->soapService);
        $this->expectException(SoapServiceNotFoundException::class);
        $registry->getServiceForPath("test1");
    }

    public function testGet(): void
    {
        $registry = new SoapServiceRegistry();
        $registry->addService("test", $this->soapService);
        $service = $registry->getServiceForPath("test");
        $this->assertInstanceOf(SoapService::class, $service);
    }
}

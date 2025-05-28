<?php

declare(strict_types=1);

namespace Test\SoapService;

use AutoSoapServer\SoapService\SoapService;
use AutoSoapServer\SoapService\SoapServiceNotFoundException;
use AutoSoapServer\SoapService\SoapServiceRegistrationFailedException;
use AutoSoapServer\SoapService\SoapServiceRegistry;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SoapServiceRegistry::class)]
class SoapServiceRegistryTest extends TestCase
{
    private SoapService $soapService;

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
        $registry->addServiceImplementation("test", $this->soapService);
        $this->assertCount(1, $registry->listPaths());
    }

    public function testDuplicatePath(): void
    {
        $registry = new SoapServiceRegistry();
        $registry->addServiceImplementation("test", $this->soapService);
        $this->expectException(SoapServiceRegistrationFailedException::class);
        $registry->addServiceImplementation("test", $this->soapService);
    }

    public function testInvalidPath(): void
    {
        $registry = new SoapServiceRegistry();
        $registry->addServiceImplementation("test", $this->soapService);
        $this->expectException(SoapServiceNotFoundException::class);
        $registry->getServiceForPath("test1");
    }

    public function testGet(): void
    {
        $registry = new SoapServiceRegistry();
        $registry->addServiceImplementation("test", $this->soapService);
        $service = $registry->getServiceForPath("test");
        $this->assertSame($this->soapService, $service->getImplementation());
    }
}

<?php

declare(strict_types=1);

namespace Test\Integration\SoapService;

use AutoSoapServer\Documentation\ComplexTypesGenerator;
use AutoSoapServer\SoapService\ClassMapGenerator;
use AutoSoapServer\SoapService\SoapServiceNotFoundException;
use AutoSoapServer\SoapService\SoapServiceRegistrationFailedException;
use AutoSoapServer\SoapService\SoapServiceRegistry;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SoapServiceRegistry::class)]
class SoapServiceRegistryTest extends TestCase
{
    private ClassMapGenerator $classMapGenerator;

    private ComplexTypesGenerator $complexTypesGenerator;

    private object $service;

    protected function setUp(): void
    {
        $this->classMapGenerator = new ClassMapGenerator();
        $this->complexTypesGenerator = new ComplexTypesGenerator();
        $this->service = new \stdClass();
    }

    public function testListEmpty(): void
    {
        $registry = new SoapServiceRegistry($this->classMapGenerator, $this->complexTypesGenerator);
        $this->assertCount(0, $registry->listPaths());
    }

    public function testListAfterAdding(): void
    {
        $registry = new SoapServiceRegistry($this->classMapGenerator, $this->complexTypesGenerator);
        $registry->addServiceImplementation("test", $this->service);
        $this->assertCount(1, $registry->listPaths());
    }

    public function testDuplicatePath(): void
    {
        $registry = new SoapServiceRegistry($this->classMapGenerator, $this->complexTypesGenerator);
        $registry->addServiceImplementation("test", $this->service);
        $this->expectException(SoapServiceRegistrationFailedException::class);
        $registry->addServiceImplementation("test", $this->service);
    }

    public function testInvalidPath(): void
    {
        $registry = new SoapServiceRegistry($this->classMapGenerator, $this->complexTypesGenerator);
        $registry->addServiceImplementation("test", $this->service);
        $this->expectException(SoapServiceNotFoundException::class);
        $registry->getServiceForPath("test1");
    }

    public function testGet(): void
    {
        $registry = new SoapServiceRegistry($this->classMapGenerator, $this->complexTypesGenerator);
        $registry->addServiceImplementation("test", $this->service);
        $service = $registry->getServiceForPath("test");
        $this->assertSame($this->service, $service->getImplementation());
    }
}

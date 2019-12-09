<?php

declare(strict_types=1);

namespace Test\Documentation;

use PHPUnit\Framework\TestCase;

use Zend\Code\Reflection\ClassReflection;

use AutoSoapServer\Documentation\DocumentedService;
use AutoSoapServer\Documentation\DocumentedMethod;
use AutoSoapServer\Documentation\DocumentedType;

use Test\Hello;

class DocumentedServiceTest extends TestCase
{
    protected $service;

    protected $emptyService;

    protected function setUp(): void
    {
        $this->service = new ClassReflection(Hello::class);
        $this->emptyService = new ClassReflection(\stdClass::class);
    }

    public function testName(): void
    {
        $documentedService = new DocumentedService("test", $this->service);
        $this->assertSame("test", $documentedService->name);
    }

    public function testShortDescription(): void
    {
        $documentedService = new DocumentedService("test", $this->service);
        $this->assertSame("Example service.", $documentedService->shortDescription);
    }

    public function testLongDescription(): void
    {
        $documentedService = new DocumentedService("test", $this->service);
        $this->assertSame("This class is used for reflection testing.", $documentedService->longDescription);
    }

    public function testNumberOfMethods(): void
    {
        $documentedService = new DocumentedService("test", $this->service);
        $this->assertGreaterThan(0, count($documentedService->methods));
    }

    public function testTypeOfMethods(): void
    {
        $documentedService = new DocumentedService("test", $this->service);
        $this->assertContainsOnlyInstancesOf(DocumentedMethod::class, $documentedService->methods);
    }

    public function testMissingShortDescription(): void
    {
        $documentedService = new DocumentedService("empty test", $this->emptyService);
        $this->assertNull($documentedService->shortDescription);
    }

    public function testMissingLongDescription(): void
    {
        $documentedService = new DocumentedService("empty test", $this->emptyService);
        $this->assertNull($documentedService->longDescription);
    }

    public function testNumberOfTypes(): void
    {
        $documentedService = new DocumentedService("complex", $this->service);
        $this->assertGreaterThan(0, count($documentedService->types));
    }

    public function testTypeOfTypes(): void
    {
        $documentedService = new DocumentedService("complex", $this->service);
        $this->assertContainsOnlyInstancesOf(DocumentedType::class, $documentedService->types);
    }
}

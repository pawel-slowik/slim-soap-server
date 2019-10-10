<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;

use Zend\Code\Reflection\ClassReflection;

use Application\Models\DocumentedService;
use Application\Models\DocumentedMethod;

class DocumentedServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        $this->service = new ClassReflection(Hello::class);
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
}

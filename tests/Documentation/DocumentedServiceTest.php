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
    protected $documentedService;

    protected $documentedEmptyService;

    protected function setUp(): void
    {
        $this->documentedService = new DocumentedService(
            "test",
            new ClassReflection(Hello::class)
        );
        $this->documentedEmptyService = new DocumentedService(
            "empty test",
            new ClassReflection(\stdClass::class)
        );
    }

    public function testName(): void
    {
        $this->assertSame(
            "test",
            $this->documentedService->name
        );
    }

    public function testShortDescription(): void
    {
        $this->assertSame(
            "Example service.",
            $this->documentedService->shortDescription
        );
    }

    public function testLongDescription(): void
    {
        $this->assertSame(
            "This class is used for reflection testing.",
            $this->documentedService->longDescription
        );
    }

    public function testNumberOfMethods(): void
    {
        $this->assertGreaterThan(
            0,
            count($this->documentedService->methods)
        );
    }

    public function testTypeOfMethods(): void
    {
        $this->assertContainsOnlyInstancesOf(
            DocumentedMethod::class,
            $this->documentedService->methods
        );
    }

    public function testMissingShortDescription(): void
    {
        $this->assertNull($this->documentedEmptyService->shortDescription);
    }

    public function testMissingLongDescription(): void
    {
        $this->assertNull($this->documentedEmptyService->longDescription);
    }

    public function testNumberOfTypes(): void
    {
        $this->assertGreaterThan(
            0,
            count($this->documentedService->types)
        );
    }

    public function testTypeOfTypes(): void
    {
        $this->assertContainsOnlyInstancesOf(
            DocumentedType::class,
            $this->documentedService->types
        );
    }
}

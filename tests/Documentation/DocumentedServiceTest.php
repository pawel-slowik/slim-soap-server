<?php

declare(strict_types=1);

namespace Test\Documentation;

use PHPUnit\Framework\TestCase;

use Zend\Code\Reflection\ClassReflection;

use AutoSoapServer\Documentation\DocumentedService;

use Test\Hello;

class DocumentedServiceTest extends TestCase
{
    protected $documentedService;

    protected $documentedEmptyService;

    protected function setUp(): void
    {
        $this->documentedService = new DocumentedService(
            "test",
            new ClassReflection(Hello::class),
            []
        );
        $this->documentedEmptyService = new DocumentedService(
            "empty test",
            new ClassReflection(\stdClass::class),
            []
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

    public function testMissingShortDescription(): void
    {
        $this->assertNull($this->documentedEmptyService->shortDescription);
    }

    public function testMissingLongDescription(): void
    {
        $this->assertNull($this->documentedEmptyService->longDescription);
    }
}

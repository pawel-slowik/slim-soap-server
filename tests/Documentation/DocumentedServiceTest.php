<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedService;
use Laminas\Code\Reflection\ClassReflection;
use PHPUnit\Framework\TestCase;
use Test\Hello;

class DocumentedServiceTest extends TestCase
{
    private DocumentedService $documentedService;

    private DocumentedService $documentedEmptyService;

    protected function setUp(): void
    {
        $this->documentedService = DocumentedService::fromClassReflection(
            "test",
            new ClassReflection(Hello::class),
            []
        );
        $this->documentedEmptyService = DocumentedService::fromClassReflection(
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

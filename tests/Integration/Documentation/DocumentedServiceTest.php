<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\DocumentedService;
use Laminas\Code\Reflection\ClassReflection;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;

class DocumentedServiceTest extends TestCase
{
    public function testName(): void
    {
        $documentedService = DocumentedService::fromClassReflection(
            "test",
            new ClassReflection(Hello::class),
            []
        );
        $this->assertSame(
            "test",
            $documentedService->name
        );
    }

    public function testShortDescription(): void
    {
        $documentedService = DocumentedService::fromClassReflection(
            "test",
            new ClassReflection(Hello::class),
            []
        );
        $this->assertSame(
            "Example service.",
            $documentedService->shortDescription
        );
    }

    public function testLongDescription(): void
    {
        $documentedService = DocumentedService::fromClassReflection(
            "test",
            new ClassReflection(Hello::class),
            []
        );
        $this->assertSame(
            "This class is used for reflection testing.",
            $documentedService->longDescription
        );
    }

    public function testMissingShortDescription(): void
    {
        $documentedEmptyService = DocumentedService::fromClassReflection(
            "empty test",
            new ClassReflection(\stdClass::class),
            []
        );
        $this->assertNull($documentedEmptyService->shortDescription);
    }

    public function testMissingLongDescription(): void
    {
        $documentedEmptyService = DocumentedService::fromClassReflection(
            "empty test",
            new ClassReflection(\stdClass::class),
            []
        );
        $this->assertNull($documentedEmptyService->longDescription);
    }
}

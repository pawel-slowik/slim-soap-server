<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\DocumentedMethod;
use AutoSoapServer\Documentation\DocumentedService;
use Laminas\Code\Reflection\ClassReflection;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;

class DocumentedServiceMethodsTest extends TestCase
{
    public function testNumberOfMethods(): void
    {
        $documentedService = DocumentedService::fromClassReflection(
            "test",
            new ClassReflection(Hello::class),
            []
        );
        $this->assertCount(
            7,
            $documentedService->methods
        );
    }

    public function testTypeOfMethods(): void
    {
        $documentedService = DocumentedService::fromClassReflection(
            "test",
            new ClassReflection(Hello::class),
            []
        );
        $this->assertContainsOnlyInstancesOf(
            DocumentedMethod::class,
            $documentedService->methods
        );
    }
}

<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\DocumentedMethod;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;
use Test\ReflectionHelper;

class DocumentedMethodIncompleteTest extends TestCase
{
    public function testReturnDescriptionNoDocBlock(): void
    {
        $documentedNoDocBlockMethod = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(
                Hello::class,
                "greetNoDocBlock"
            )
        );
        $this->assertNull($documentedNoDocBlockMethod->returnDescription);
    }

    public function testReturnDescriptionIncompleteDocBlock(): void
    {
        $documentedIncompleteDocBlockMethod = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(
                Hello::class,
                "greetIncompleteDocBlock"
            )
        );
        $this->assertNull($documentedIncompleteDocBlockMethod->returnDescription);
    }
}

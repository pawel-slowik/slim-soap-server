<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\DocumentedMethod;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;
use Test\ReflectionHelper;

class DocumentedMethodIncompleteTest extends TestCase
{
    private DocumentedMethod $documentedNoDocBlockMethod;

    private DocumentedMethod $documentedIncompleteDocBlockMethod;

    protected function setUp(): void
    {
        $this->documentedNoDocBlockMethod = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(
                Hello::class,
                "greetNoDocBlock"
            )
        );
        $this->documentedIncompleteDocBlockMethod = DocumentedMethod::fromMethodReflection(
            ReflectionHelper::getReflectedMethod(
                Hello::class,
                "greetIncompleteDocBlock"
            )
        );
    }

    public function testReturnDescriptionNoDocBlock(): void
    {
        $this->assertNull($this->documentedNoDocBlockMethod->returnDescription);
    }

    public function testReturnDescriptionIncompleteDocBlock(): void
    {
        $this->assertNull($this->documentedIncompleteDocBlockMethod->returnDescription);
    }
}

<?php

declare(strict_types=1);

namespace Test\Unit\Documentation;

use AutoSoapServer\Documentation\DocumentedParameter;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;
use Test\ReflectionHelper;

#[CoversClass(DocumentedParameter::class)]
class DocumentedParameterIncompleteTest extends TestCase
{
    public function testNoDocBlockNoDescription(): void
    {
        $documentedNoDocBlockParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(
                Hello::class,
                "greetNoDocBlock",
                "subject"
            )
        );
        $this->assertNull($documentedNoDocBlockParameter->description);
    }

    public function testNoDocBlockNoDefaultValue(): void
    {
        $documentedNoDocBlockParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(
                Hello::class,
                "greetNoDocBlock",
                "subject"
            )
        );
        $this->assertNull($documentedNoDocBlockParameter->defaultValue);
    }

    public function testIncompleteDocBlockNoDescription(): void
    {
        $documentedIncompleteDocBlockParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(
                Hello::class,
                "greetIncompleteDocBlock",
                "subject"
            )
        );
        $this->assertNull($documentedIncompleteDocBlockParameter->description);
    }
}

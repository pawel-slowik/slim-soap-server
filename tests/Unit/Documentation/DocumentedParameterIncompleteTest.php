<?php

declare(strict_types=1);

namespace Test\Unit\Documentation;

use AutoSoapServer\Documentation\DocumentedParameter;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;
use Test\ReflectionHelper;

class DocumentedParameterIncompleteTest extends TestCase
{
    private DocumentedParameter $documentedNoDocBlockParameter;

    private DocumentedParameter $documentedIncompleteDocBlockParameter;

    protected function setUp(): void
    {
        $this->documentedNoDocBlockParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(
                Hello::class,
                "greetNoDocBlock",
                "subject"
            )
        );
        $this->documentedIncompleteDocBlockParameter = DocumentedParameter::fromParameterReflection(
            ReflectionHelper::getReflectedParameter(
                Hello::class,
                "greetIncompleteDocBlock",
                "subject"
            )
        );
    }

    public function testNoDocBlockNoDescription(): void
    {
        $this->assertNull($this->documentedNoDocBlockParameter->description);
    }

    public function testNoDocBlockNoDefaultValue(): void
    {
        $this->assertNull($this->documentedNoDocBlockParameter->defaultValue);
    }

    public function testIncompleteDocBlockNoDescription(): void
    {
        $this->assertNull($this->documentedIncompleteDocBlockParameter->description);
    }
}

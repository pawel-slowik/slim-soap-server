<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedParameter;
use Test\Hello;

class DocumentedParameterIncompleteTest extends DocumentedTestBase
{
    private DocumentedParameter $documentedNoDocBlockParameter;

    private DocumentedParameter $documentedIncompleteDocBlockParameter;

    protected function setUp(): void
    {
        $this->documentedNoDocBlockParameter = DocumentedParameter::fromParameterReflection(
            $this->getReflectedParameter(
                Hello::class,
                "greetNoDocBlock",
                "subject"
            )
        );
        $this->documentedIncompleteDocBlockParameter = DocumentedParameter::fromParameterReflection(
            $this->getReflectedParameter(
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

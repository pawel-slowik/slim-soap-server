<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedParameter;

use Test\Hello;

class DocumentedParameterIncompleteTest extends DocumentedTestBase
{
    protected $noDocBlockParameter;

    protected $incompleteDocBlockParameter;

    protected function setUp(): void
    {
        $this->noDocBlockParameter = $this->getReflectedParameter(
            Hello::class,
            "greetNoDocBlock",
            "subject"
        );
        $this->incompleteDocBlockParameter = $this->getReflectedParameter(
            Hello::class,
            "greetIncompleteDocBlock",
            "subject"
        );
    }

    public function testNoDocBlockNoDescription(): void
    {
        $documentedParameter = new DocumentedParameter($this->noDocBlockParameter);
        $this->assertNull($documentedParameter->description);
    }

    public function testNoDocBlockNoDefaultValue(): void
    {
        $documentedParameter = new DocumentedParameter($this->noDocBlockParameter);
        $this->assertNull($documentedParameter->defaultValue);
    }

    public function testIncompleteDocBlockNoDescription(): void
    {
        $documentedParameter = new DocumentedParameter($this->incompleteDocBlockParameter);
        $this->assertNull($documentedParameter->description);
    }
}

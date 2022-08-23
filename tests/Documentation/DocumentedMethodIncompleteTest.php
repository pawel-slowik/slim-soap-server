<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedMethod;
use Test\Hello;

class DocumentedMethodIncompleteTest extends DocumentedTestBase
{
    private DocumentedMethod $documentedNoDocBlockMethod;

    private DocumentedMethod $documentedIncompleteDocBlockMethod;

    protected function setUp(): void
    {
        $this->documentedNoDocBlockMethod = new DocumentedMethod(
            $this->getReflectedMethod(
                Hello::class,
                "greetNoDocBlock"
            )
        );
        $this->documentedIncompleteDocBlockMethod = new DocumentedMethod(
            $this->getReflectedMethod(
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

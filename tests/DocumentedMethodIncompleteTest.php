<?php

declare(strict_types=1);

namespace Test;

use Application\Models\DocumentedMethod;

class DocumentedMethodIncompleteTest extends DocumentedTestBase
{
    protected $noDocBlockMethod;

    protected $incompleteDocBlockMethod;

    protected function setUp(): void
    {
        $this->noDocBlockMethod = $this->getReflectedMethod(Hello::class, "greetNoDocBlock");
        $this->incompleteDocBlockMethod = $this->getReflectedMethod(Hello::class, "greetIncompleteDocBlock");
    }

    public function testReturnDescriptionNoDocBlock(): void
    {
        $documentedMethod = new DocumentedMethod($this->noDocBlockMethod);
        $this->assertNull($documentedMethod->returnDescription);
    }

    public function testReturnDescriptionIncompleteDocBlock(): void
    {
        $documentedMethod = new DocumentedMethod($this->incompleteDocBlockMethod);
        $this->assertNull($documentedMethod->returnDescription);
    }
}

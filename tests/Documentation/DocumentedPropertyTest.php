<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedType;

class DocumentedPropertyTest extends DocumentedTestBase
{
    private DocumentedType $documentedType;

    protected function setUp(): void
    {
        $this->documentedType = new DocumentedType("\\Test\\Type");
    }

    public function testName(): void
    {
        $this->assertSame(
            "bar",
            $this->documentedType->properties[0]->name
        );
    }

    public function testDescription(): void
    {
        $this->assertSame(
            "bar property description",
            $this->documentedType->properties[0]->description
        );
    }

    public function testTypes(): void
    {
        $this->assertSame(
            ["string"],
            $this->documentedType->properties[0]->types
        );
    }

    public function testMissingDescription(): void
    {
        $this->assertNull($this->documentedType->properties[1]->description);
    }

    public function testMissingType(): void
    {
        $this->assertNull($this->documentedType->properties[2]->types);
    }
}

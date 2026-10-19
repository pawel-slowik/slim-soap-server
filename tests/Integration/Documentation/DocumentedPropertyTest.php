<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\DocumentedType;
use PHPUnit\Framework\TestCase;

class DocumentedPropertyTest extends TestCase
{
    private DocumentedType $documentedType;

    protected function setUp(): void
    {
        $this->documentedType = DocumentedType::fromClassName("\\Test\\Fixture\\Type");
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

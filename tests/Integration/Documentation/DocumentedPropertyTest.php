<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\DocumentedType;
use PHPUnit\Framework\TestCase;

class DocumentedPropertyTest extends TestCase
{
    public function testName(): void
    {
        $documentedType = DocumentedType::fromClassName("\\Test\\Fixture\\Type");
        $this->assertSame(
            "bar",
            $documentedType->properties[0]->name
        );
    }

    public function testDescription(): void
    {
        $documentedType = DocumentedType::fromClassName("\\Test\\Fixture\\Type");
        $this->assertSame(
            "bar property description",
            $documentedType->properties[0]->description
        );
    }

    public function testTypes(): void
    {
        $documentedType = DocumentedType::fromClassName("\\Test\\Fixture\\Type");
        $this->assertSame(
            ["string"],
            $documentedType->properties[0]->types
        );
    }

    public function testMissingDescription(): void
    {
        $documentedType = DocumentedType::fromClassName("\\Test\\Fixture\\Type");
        $this->assertNull($documentedType->properties[1]->description);
    }

    public function testMissingType(): void
    {
        $documentedType = DocumentedType::fromClassName("\\Test\\Fixture\\Type");
        $this->assertNull($documentedType->properties[2]->types);
    }
}

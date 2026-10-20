<?php

declare(strict_types=1);

namespace Test\Integration\Documentation;

use AutoSoapServer\Documentation\DocumentedProperty;
use AutoSoapServer\Documentation\DocumentedType;
use PHPUnit\Framework\TestCase;

class DocumentedTypeTest extends TestCase
{
    public function testName(): void
    {
        $documentedType = DocumentedType::fromClassName("\\Test\\Fixture\\Type");
        $this->assertSame(
            "Test\\Fixture\\Type",
            $documentedType->name
        );
    }

    public function testDescription(): void
    {
        $documentedType = DocumentedType::fromClassName("\\Test\\Fixture\\Type");
        $this->assertSame(
            "This class is used for type reflection testing.",
            $documentedType->description
        );
    }

    public function testNumberOfProperties(): void
    {
        $documentedType = DocumentedType::fromClassName("\\Test\\Fixture\\Type");
        $this->assertCount(
            5,
            $documentedType->properties
        );
    }

    public function testTypeOfProperties(): void
    {
        $documentedType = DocumentedType::fromClassName("\\Test\\Fixture\\Type");
        $this->assertContainsOnlyInstancesOf(
            DocumentedProperty::class,
            $documentedType->properties
        );
    }
}

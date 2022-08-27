<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedProperty;
use AutoSoapServer\Documentation\DocumentedType;

class DocumentedTypeTest extends DocumentedTestBase
{
    private DocumentedType $documentedType;

    protected function setUp(): void
    {
        $this->documentedType = DocumentedType::fromClassName("\\Test\\Type");
    }

    public function testName(): void
    {
        $this->assertSame(
            "Test\\Type",
            $this->documentedType->name
        );
    }

    public function testDescription(): void
    {
        $this->assertSame(
            "This class is used for type reflection testing.",
            $this->documentedType->description
        );
    }

    public function testNumberOfProperties(): void
    {
        $this->assertCount(
            5,
            $this->documentedType->properties
        );
    }

    public function testTypeOfProperties(): void
    {
        $this->assertContainsOnlyInstancesOf(
            DocumentedProperty::class,
            $this->documentedType->properties
        );
    }
}

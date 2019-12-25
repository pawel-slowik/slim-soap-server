<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedType;
use AutoSoapServer\Documentation\DocumentedProperty;

use Test\Hello;

class DocumentedTypeTest extends DocumentedTestBase
{
    protected $documentedType;

    protected function setUp(): void
    {
        $parameter = $this->getReflectedParameter(
            Hello::class,
            "methodWithComplexInputType",
            "foo"
        );
        $this->documentedType = new DocumentedType($parameter->getType());
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
            3,
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

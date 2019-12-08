<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Models\DocumentedType;
use AutoSoapServer\Models\DocumentedProperty;

use Test\Hello;

class DocumentedTypeTest extends DocumentedTestBase
{
    protected $type;

    protected function setUp(): void
    {
        $parameter = $this->getReflectedParameter(Hello::class, "methodWithComplexInputType", "foo");
        $this->type = $parameter->getType();
    }

    public function testName(): void
    {
        $documentedType = new DocumentedType($this->type);
        $this->assertSame("Test\\Type", $documentedType->name);
    }

    public function testDescription(): void
    {
        $documentedType = new DocumentedType($this->type);
        $this->assertSame("This class is used for type reflection testing.", $documentedType->description);
    }

    public function testNumberOfProperties(): void
    {
        $documentedType = new DocumentedType($this->type);
        $this->assertCount(3, $documentedType->properties);
    }

    public function testTypeOfProperties(): void
    {
        $documentedType = new DocumentedType($this->type);
        $this->assertContainsOnlyInstancesOf(DocumentedProperty::class, $documentedType->properties);
    }
}

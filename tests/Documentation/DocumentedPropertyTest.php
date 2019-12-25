<?php

declare(strict_types=1);

namespace Test\Documentation;

use AutoSoapServer\Documentation\DocumentedType;
use AutoSoapServer\Documentation\DocumentedProperty;

use Test\Hello;

class DocumentedPropertyTest extends DocumentedTestBase
{
    protected $documentedType;

    protected function setUp(): void
    {
        $parameter = $this->getReflectedParameter(Hello::class, "methodWithComplexInputType", "foo");
        $this->documentedType = new DocumentedType($parameter->getType());
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

<?php

declare(strict_types=1);

namespace Test\Unit\Documentation;

use AutoSoapServer\Documentation\ComplexTypesGenerator;
use AutoSoapServer\SoapService\MappedComplexType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ComplexTypesGenerator::class)]
class ComplexTypesGeneratorTest extends TestCase
{
    private ComplexTypesGenerator $complexTypesGenerator;

    protected function setUp(): void
    {
        $this->complexTypesGenerator = new ComplexTypesGenerator();
    }

    public function testTypes(): void
    {
        $mappedComplexTypes = [
            new MappedComplexType("\\Namespace\\Foo", "tns:Foo"),
            new MappedComplexType("\\Namespace\\Bar", "tns:Bar"),
            new MappedComplexType("\\Namespace\\Foo", "tns:Foo"),
        ];

        $expectedTypes = [
            "\\Namespace\\Foo",
            "\\Namespace\\Bar",
        ];

        $this->assertSame($expectedTypes, $this->complexTypesGenerator->generate($mappedComplexTypes));
    }
}

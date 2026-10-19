<?php

declare(strict_types=1);

namespace Test\Unit\SoapService;

use AutoSoapServer\SoapService\ClassMapGenerator;
use AutoSoapServer\SoapService\MappedComplexType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ClassMapGenerator::class)]
class ClassMapGeneratorTest extends TestCase
{
    private ClassMapGenerator $classMapGenerator;

    protected function setUp(): void
    {
        $this->classMapGenerator = new ClassMapGenerator();
    }

    public function testMap(): void
    {
        $mappedComplexTypes = [
            new MappedComplexType("\\Namespace\\Foo", "tns:Foo"),
            new MappedComplexType("\\Namespace\\Bar", "tns:Bar"),
            new MappedComplexType("\\Namespace\\Foo", "tns:Foo"),
        ];

        $expectedClassMap = [
            "Foo" => "\\Namespace\\Foo",
            "Bar" => "\\Namespace\\Bar",
        ];

        $this->assertSame($expectedClassMap, $this->classMapGenerator->generate($mappedComplexTypes));
    }
}

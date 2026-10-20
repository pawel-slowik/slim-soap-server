<?php

declare(strict_types=1);

namespace Test\Unit\SoapService;

use AutoSoapServer\SoapService\ComplexTypeStrategySpy;
use AutoSoapServer\SoapService\MappedComplexType;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\ComplexTypeStrategyInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

#[CoversClass(ComplexTypeStrategySpy::class)]
class ComplexTypeStrategySpyTest extends TestCase
{
    private ComplexTypeStrategyInterface&Stub $complexTypeStrategy;

    private ComplexTypeStrategySpy $complexTypeStrategySpy;

    protected function setUp(): void
    {
        $this->complexTypeStrategy = $this->createStub(ComplexTypeStrategyInterface::class);
        $this->complexTypeStrategySpy = new ComplexTypeStrategySpy($this->complexTypeStrategy);
    }

    public function testSpiedTypes(): void
    {
        $this->complexTypeStrategy->method("addComplexType")->willReturnMap(
            [
                ["foo", "f_type"],
                ["bar", "BarType"],
            ]
        );

        $this->complexTypeStrategySpy->addComplexType("foo");
        $this->complexTypeStrategySpy->addComplexType("bar");
        $types = $this->complexTypeStrategySpy->getSpiedTypes();

        $this->assertCount(2, $types);
        $this->assertContainsEquals(new MappedComplexType(type: "foo", xsdType: "f_type"), $types);
        $this->assertContainsEquals(new MappedComplexType(type: "bar", xsdType: "BarType"), $types);
    }
}

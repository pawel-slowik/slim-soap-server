<?php

declare(strict_types=1);

namespace Test\Integration\SoapService;

use AutoSoapServer\SoapService\ComplexTypeStrategySpy;
use AutoSoapServer\SoapService\SoapService;
use LogicException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;
use Test\Fixture\Hello;

#[CoversClass(ComplexTypeStrategySpy::class)]
#[CoversClass(SoapService::class)]
class SoapServiceTest extends TestCase
{
    private const string FIXTURE_DIR = __DIR__ . "/../../Fixture";

    private object $emptyImplementation;

    private object $helloImplementation;

    private string $validHelloMessage;

    protected function setUp(): void
    {
        $this->emptyImplementation = new \stdClass();
        $this->helloImplementation = new Hello();
        $validHelloMessage = file_get_contents(self::FIXTURE_DIR . "/hello_request.xml") or throw new LogicException();
        $this->validHelloMessage = $validHelloMessage;
    }

    public function testName(): void
    {
        $service = new SoapService($this->emptyImplementation);
        $this->assertIsString($service->getName());
    }

    public function testNoDescription(): void
    {
        $service = new SoapService($this->emptyImplementation);
        $this->assertNull($service->getDescription());
    }

    public function testDescription(): void
    {
        $service = new SoapService($this->helloImplementation);
        $this->assertIsString($service->getDescription());
    }

    public function testImplementation(): void
    {
        $service = new SoapService($this->emptyImplementation);
        $this->assertSame($this->emptyImplementation, $service->getImplementation());
    }

    public function testWsdXmlIsValid(): void
    {
        $service = new SoapService($this->emptyImplementation);
        $wsdlDocument = $service->createWsdlDocument("http://foo/bar");
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $wsdlDocument->xml);
    }

    #[RunInSeparateProcess] // see Test\Functional\EndpointTest::testStatus
    public function testHandleReturnsString(): void
    {
        $service = new SoapService($this->helloImplementation);
        $output = $service->handleSoapMessage(
            "http://foo/bar.wsdl",
            "http://foo/bar",
            $this->validHelloMessage
        );
        $this->assertIsString($output);
    }

    #[RunInSeparateProcess] // see Test\Functional\EndpointTest::testStatus
    public function testHandleReturnsValid(): void
    {
        $service = new SoapService($this->helloImplementation);
        $output = $service->handleSoapMessage(
            "http://foo/bar.wsdl",
            "http://foo/bar",
            $this->validHelloMessage
        );
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $output);
    }
}

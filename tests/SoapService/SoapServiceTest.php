<?php

declare(strict_types=1);

namespace Test\SoapService;

use PHPUnit\Framework\TestCase;

use AutoSoapServer\Models\SoapService;

use Test\Hello;

/**
 * @covers \AutoSoapServer\Models\SoapService
 */
class SoapServiceTest extends TestCase
{
    protected $emptyImplementation;

    protected $helloImplementation;

    protected $validHelloMessage;

    protected function setUp(): void
    {
        $this->emptyImplementation = new \stdClass();
        $this->helloImplementation = new Hello();
        $this->validHelloMessage = file_get_contents(__DIR__ . "/../data/hello_request.xml");
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

    public function testWsdlIsObject(): void
    {
        $service = new SoapService($this->emptyImplementation);
        $wsdlDocument = $service->createWsdlDocument("http://foo/bar");
        $this->assertIsObject($wsdlDocument);
    }

    public function testWsdlIsXmlable(): void
    {
        $service = new SoapService($this->emptyImplementation);
        $wsdlDocument = $service->createWsdlDocument("http://foo/bar");
        $this->assertTrue(method_exists($wsdlDocument, "saveXML"));
    }

    public function testWsdlIsValid(): void
    {
        $service = new SoapService($this->emptyImplementation);
        $wsdlDocument = $service->createWsdlDocument("http://foo/bar");
        $xml = $wsdlDocument->saveXML();
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $xml);
    }

    /**
     * @runInSeparateProcess - see Test\Functional\EndpointTest::testStatus
     */
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

    /**
     * @runInSeparateProcess - see Test\Functional\EndpointTest::testStatus
     */
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

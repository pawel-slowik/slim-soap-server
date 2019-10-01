<?php

declare(strict_types=1);

namespace Test\Functional;

class EndpointTest extends BaseTestCase
{
    protected $message;

    protected function setUp(): void
    {
        $this->message = $this->loadTestFile("hello_request.xml");
    }

    public function testStatus(): void
    {
        // TODO: This can't be easily tested because the SoapServer tries to
        // access a non-existent WSDL URL (based on a mocked environment).
        //
        // Maybe use the "data://" stream wrapper for the WSDL URL?
        //
        // PHP Warning:  SoapServer::SoapServer(http://localhost/hello/wsdl):
        // failed to open stream: Connection refused in
        // /home/test/soap-server/vendor/zendframework/zend-soap/src/Server.php
        // on line 914
        //
        // PHP Warning:  SoapServer::SoapServer(): I/O warning : failed to load
        // external entity "http://localhost/hello/wsdl" in
        // /home/test/soap-server/vendor/zendframework/zend-soap/src/Server.php
        // on line 914
        //
        // PHP Fatal error:  SOAP-ERROR: Parsing WSDL: Couldn't load from
        // 'http://localhost/hello/wsdl' : failed to load external entity
        // "http://localhost/hello/wsdl"
        //  in /home/test/soap-server/vendor/zendframework/zend-soap/src/Server.php on line 914
        //
        // $response = $this->runApp("POST", "/hello", $this->message);
        // $this->assertSame(200, $response->getStatusCode());
        $this->markTestIncomplete();
    }

    public function testContentType(): void
    {
        // TODO: see testStatus
        // $response = $this->runApp("POST", "/hello", $this->message);
        // $this->assertStringStartsWith("text/xml", $response->getHeader("content-type")[0]);
        $this->markTestIncomplete();
    }

    public function testBody(): void
    {
        $expected = $this->loadTestFile("hello_response.xml");
        // TODO: see testStatus
        // $response = $this->runApp("POST", "/hello", $this->message);
        // $this->assertXmlStringEqualsXmlString((string) $response->getBody(), $expected);
        $this->markTestIncomplete();
    }

    public function testGetNotAllowed(): void
    {
        $response = $this->runApp("GET", "/hello", $this->message);
        $this->assertSame(405, $response->getStatusCode());
    }
}

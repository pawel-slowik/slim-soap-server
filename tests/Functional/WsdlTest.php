<?php

declare(strict_types=1);

namespace Test\Functional;

class WsdlTest extends BaseTestCase
{
    public function testStatus(): void
    {
        $response = $this->runApp("GET", "/hello/wsdl");
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testContentType(): void
    {
        $response = $this->runApp("GET", "/hello/wsdl");
        $this->assertStringStartsWith("text/xml", $response->getHeader("content-type")[0]);
    }

    public function testBody(): void
    {
        $response = $this->runApp("GET", "/hello/wsdl");
        $expected = $this->loadTestFile("hello.wsdl");
        $this->assertXmlStringEqualsXmlString((string) $response->getBody(), $expected);
    }

    public function testPostNotAllowed(): void
    {
        $response = $this->runApp("POST", "/hello/wsdl");
        $this->assertSame(405, $response->getStatusCode());
    }
}

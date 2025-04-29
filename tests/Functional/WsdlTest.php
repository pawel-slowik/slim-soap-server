<?php

declare(strict_types=1);

namespace Test\Functional;

use AutoSoapServer\Controllers\WsdlController;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(WsdlController::class)]
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
        $this->assertStringStartsWith('<?xml version="1.0"', (string) $response->getBody());
    }

    public function testPostNotAllowed(): void
    {
        $response = $this->runApp("POST", "/hello/wsdl");
        $this->assertSame(405, $response->getStatusCode());
    }
}

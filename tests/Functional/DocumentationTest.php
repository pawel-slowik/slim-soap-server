<?php

declare(strict_types=1);

namespace Test\Functional;

/**
 * @covers \AutoSoapServer\Controllers\DocumentationController
 */
class DocumentationTest extends BaseTestCase
{
    public function testStatus(): void
    {
        $response = $this->runApp("GET", "/hello/doc");
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testContentType(): void
    {
        $response = $this->runApp("GET", "/hello/doc");
        $this->assertStringStartsWith("text/html", $response->getHeader("content-type")[0]);
    }

    public function testBody(): void
    {
        $response = $this->runApp("GET", "/hello/doc");
        $this->assertNotEmpty((string) $response->getBody());
    }

    public function testPostNotAllowed(): void
    {
        $response = $this->runApp("POST", "/hello/doc");
        $this->assertSame(405, $response->getStatusCode());
    }
}

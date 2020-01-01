<?php

declare(strict_types=1);

namespace Test\Functional;

/**
 * @covers \AutoSoapServer\ErrorHandlers\HttpMethodNotAllowedHandler
 * @covers \AutoSoapServer\ErrorHandlers\HttpNotFoundHandler
 */
class HttpErrorTest extends BaseTestCase
{
    public function testMethodNotAllowed(): void
    {
        $response = $this->runApp("PUT", "/");
        $this->assertSame(405, $response->getStatusCode());
        $this->assertStringContainsString("405", (string) $response->getBody());
    }

    public function testNotFound(): void
    {
        $response = $this->runApp("GET", "/there-is-no-such-path");
        $this->assertSame(404, $response->getStatusCode());
        $this->assertStringContainsString("404", (string) $response->getBody());
    }
}

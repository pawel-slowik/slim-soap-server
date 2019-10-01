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

    /**
     * @runInSeparateProcess
     *
     * \SoapServer::handle(...) automatically sends HTTP headers. Since PHPUnit
     * output starts before the test, this causes "Cannot modify header
     * information - headers already sent" warnings.
     *
     * The automatic headers are redundant (all necessary headers should be set
     * by EndpointController), but there's no way to disable them.
     *
     * Running the test in a separate process hides the warnings.
     */
    public function testStatus(): void
    {
        $response = $this->runApp("POST", "/hello", $this->message);
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @runInSeparateProcess - see testStatus
     */
    public function testContentType(): void
    {
        $response = $this->runApp("POST", "/hello", $this->message);
        $this->assertStringStartsWith("application/soap+xml", $response->getHeader("content-type")[0]);
    }

    /**
     * @runInSeparateProcess - see testStatus
     */
    public function testBody(): void
    {
        $expected = $this->loadTestFile("hello_response.xml");
        $response = $this->runApp("POST", "/hello", $this->message);
        $this->assertXmlStringEqualsXmlString((string) $response->getBody(), $expected);
    }

    public function testGetNotAllowed(): void
    {
        $response = $this->runApp("GET", "/hello", $this->message);
        $this->assertSame(405, $response->getStatusCode());
    }
}

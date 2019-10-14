<?php

declare(strict_types=1);

namespace Test\Functional;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Stream;
use Slim\Http\Environment;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function runApp(string $requestMethod, string $requestUri, ?string $requestBody = null): Response
    {
        $environment = Environment::mock(
            [
                "REQUEST_METHOD" => $requestMethod,
                "REQUEST_URI" => $requestUri,
            ]
        );
        $request = Request::createFromEnvironment($environment);
        if (isset($requestBody)) {
            $request = $request->withBody($this->stringToStream($requestBody));
        }

        $response = new Response();
        $app = new App();
        $dependencies = require __DIR__ . "/../../src/dependencies.php";
        $dependencies($app);
        $routes = require __DIR__ . "/../../src/routes.php";
        $routes($app);
        $response = $app->process($request, $response);

        return $response;
    }

    protected function loadTestFile(string $filename): string
    {
        $contents = file_get_contents(__DIR__ . "/../data/" . $filename);
        if ($contents === false) {
            throw new \LogicException();
        }
        return $contents;
    }

    protected function stringToStream(string $content): Stream
    {
        $stream = new Stream(fopen("php://temp", "r+"));
        $stream->write($content);
        return $stream;
    }
}

<?php

declare(strict_types=1);

namespace Test\Functional;

use Psr\Http\Message\ResponseInterface;
use DI\Container;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\ServerRequest;
use Nyholm\Psr7\Uri;
use Slim\App;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function runApp(string $requestMethod, string $requestUri, ?string $requestBody = null): ResponseInterface
    {
        $uri = (new Uri())->withScheme('http')->withHost('localhost')->withPath($requestUri);
        $request = new ServerRequest($requestMethod, $uri);
        if (isset($requestBody)) {
            $request->getBody()->write($requestBody);
        }

        $app = new App(new Psr17Factory(), new Container());
        $dependencies = require __DIR__ . "/../../src/dependencies.php";
        $dependencies($app);
        $middleware = require __DIR__ . "/../../src/middleware.php";
        $middleware($app);
        $routes = require __DIR__ . "/../../src/routes.php";
        $routes($app);
        $response = $app->handle($request);

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
}

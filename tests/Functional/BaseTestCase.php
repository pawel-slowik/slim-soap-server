<?php

declare(strict_types=1);

namespace Test\Functional;

use AutoSoapServer\RoutingConfiguration;
use DI\Container;
use LogicException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\ServerRequest;
use Nyholm\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

abstract class BaseTestCase extends TestCase
{
    protected function runApp(string $requestMethod, string $requestUri, ?string $requestBody = null): ResponseInterface
    {
        $uri = (new Uri())->withScheme('http')->withHost('localhost')->withPath($requestUri);
        $request = new ServerRequest($requestMethod, $uri);
        if (isset($requestBody)) {
            $request->getBody()->write($requestBody);
        }

        $container = new Container();
        $app = new App(new Psr17Factory(), $container);
        $dependencies = require __DIR__ . "/../../src/dependencies.php";
        $dependencies($container, $app);
        $middleware = require __DIR__ . "/../../src/middleware.php";
        $middleware($app);
        $routingConfiguration = $container->get(RoutingConfiguration::class);
        $app = $routingConfiguration->apply($app);
        $response = $app->handle($request);

        return $response;
    }

    protected function loadTestFile(string $filename): string
    {
        $contents = file_get_contents(__DIR__ . "/../data/" . $filename);
        if ($contents === false) {
            throw new LogicException();
        }
        return $contents;
    }
}

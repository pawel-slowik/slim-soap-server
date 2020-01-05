<?php

declare(strict_types=1);

use AutoSoapServer\SoapService\SoapService;
use AutoSoapServer\SoapService\SoapServiceRegistry;

use Slim\App;
use Slim\Views\Twig;
use Slim\Interfaces\RouteParserInterface;

use ExampleServices\Hello;
use ExampleServices\ExampleServiceWithComplexTypes;

return function (App $app): void {
    // TODO: more DI improvements?

    $container = $app->getContainer();

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    $container->set(RouteParserInterface::class, function ($container) use ($app) {
        return $app->getRouteCollector()->getRouteParser();
    });

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    $container->set(Twig::class, function ($container) {
        return Twig::create(
            "templates",
            [
                "cache" => "/tmp/twig_cache",
                "auto_reload" => true,
            ]
        );
    });

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    $container->set(SoapServiceRegistry::class, function ($container) {
        $reg = new SoapServiceRegistry();
        $reg->addService("hello", new SoapService(new Hello()));
        $reg->addService("complex", new SoapService(new ExampleServiceWithComplexTypes()));
        return $reg;
    });
};

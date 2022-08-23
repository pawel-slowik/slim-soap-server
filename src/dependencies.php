<?php

declare(strict_types=1);

use AutoSoapServer\SoapService\SoapServiceRegistry;

use DI\Container;
use ExampleServices\ExampleServiceWithComplexTypes;
use ExampleServices\Hello;
use Slim\App;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;

return function (Container $container, App $app): void {
    $dependencies = [

        // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
        RouteParserInterface::class => fn ($container) => $app->getRouteCollector()->getRouteParser(),

        // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
        Twig::class => fn ($container) => Twig::create(
            __DIR__ . "/../templates",
            [
                "cache" => "/tmp/twig_cache",
                "auto_reload" => true,
            ]
        ),

        // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
        SoapServiceRegistry::class => function ($container) {
            $reg = new SoapServiceRegistry();
            $reg->addServiceImplementation("hello", new Hello());
            $reg->addServiceImplementation("complex", new ExampleServiceWithComplexTypes());
            return $reg;
        },
    ];

    foreach ($dependencies as $dependency => $factory) {
        $container->set($dependency, $factory);
    }
};

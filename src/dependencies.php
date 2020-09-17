<?php

declare(strict_types=1);

use AutoSoapServer\SoapService\SoapServiceRegistry;

use DI\Container;
use Slim\App;
use Slim\Views\Twig;
use Slim\Interfaces\RouteParserInterface;

use ExampleServices\Hello;
use ExampleServices\ExampleServiceWithComplexTypes;

return function (Container $container, App $app): void {
    $dependencies = [

        // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
        RouteParserInterface::class => function ($container) use ($app) {
            return $app->getRouteCollector()->getRouteParser();
        },

        // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
        Twig::class => function ($container) {
            return Twig::create(
                "templates",
                [
                    "cache" => "/tmp/twig_cache",
                    "auto_reload" => true,
                ]
            );
        },

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

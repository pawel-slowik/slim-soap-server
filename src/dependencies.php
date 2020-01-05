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
            $reg->addService("hello", new SoapService(new Hello()));
            $reg->addService("complex", new SoapService(new ExampleServiceWithComplexTypes()));
            return $reg;
        },
    ];

    foreach ($dependencies as $dependency => $factory) {
        $app->getContainer()->set($dependency, $factory);
    }
};

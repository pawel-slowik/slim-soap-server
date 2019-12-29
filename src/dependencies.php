<?php

declare(strict_types=1);

use AutoSoapServer\SoapService\SoapService;
use AutoSoapServer\SoapService\SoapServiceRegistry;
use AutoSoapServer\Documentation\DocumentationGenerator;
use AutoSoapServer\Controllers\HomeController;
use AutoSoapServer\Controllers\WsdlController;
use AutoSoapServer\Controllers\EndpointController;
use AutoSoapServer\Controllers\DocumentationController;

use Slim\App;

use ExampleServices\Hello;
use ExampleServices\ExampleServiceWithComplexTypes;

return function (App $app): void {
    // TODO: improve DI, autowiring maybe?

    $container = $app->getContainer();

    $container["view"] = function ($container) {
        $options = [
            "cache" => "/tmp/twig_cache",
            "auto_reload" => true,
        ];
        $view = new \Slim\Views\Twig("templates", $options);
        $router = $container->get("router");
        $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
        $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
        return $view;
    };

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    $container["documentationGenerator"] = function ($container) {
        return new DocumentationGenerator();
    };

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    $container["soapServiceRegistry"] = function ($container) {
        $reg = new SoapServiceRegistry();
        $reg->addService("hello", new SoapService(new Hello()));
        $reg->addService("complex", new SoapService(new ExampleServiceWithComplexTypes()));
        return $reg;
    };

    $container[HomeController::class] = function ($container) {
        return new HomeController(
            $container->get("soapServiceRegistry"),
            $container->get("view")
        );
    };

    $container[WsdlController::class] = function ($container) {
        return new WsdlController(
            $container->get("soapServiceRegistry"),
            $container->get("router")
        );
    };

    $container[EndpointController::class] = function ($container) {
        return new EndpointController(
            $container->get("soapServiceRegistry"),
            $container->get("router")
        );
    };

    $container[DocumentationController::class] = function ($container) {
        return new DocumentationController(
            $container->get("soapServiceRegistry"),
            $container->get("documentationGenerator"),
            $container->get("view")
        );
    };
};

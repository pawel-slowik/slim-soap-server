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
use Slim\Views\Twig;

use ExampleServices\Hello;
use ExampleServices\ExampleServiceWithComplexTypes;

return function (App $app): void {
    // TODO: improve DI, autowiring maybe?

    $container = $app->getContainer();

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    $container->set("view", function ($container) {
        $options = [
            "cache" => "/tmp/twig_cache",
            "auto_reload" => true,
        ];
        return Twig::create("templates", $options);
    });

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    $container->set("documentationGenerator", function ($container) {
        return new DocumentationGenerator();
    });

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    $container->set("soapServiceRegistry", function ($container) {
        $reg = new SoapServiceRegistry();
        $reg->addService("hello", new SoapService(new Hello()));
        $reg->addService("complex", new SoapService(new ExampleServiceWithComplexTypes()));
        return $reg;
    });

    $container->set(HomeController::class, function ($container) {
        return new HomeController(
            $container->get("soapServiceRegistry"),
            $container->get("view")
        );
    });

    $container->set(WsdlController::class, function ($container) use ($app) {
        return new WsdlController(
            $container->get("soapServiceRegistry"),
            $app->getRouteCollector()->getRouteParser()
        );
    });

    $container->set(EndpointController::class, function ($container) use ($app) {
        return new EndpointController(
            $container->get("soapServiceRegistry"),
            $app->getRouteCollector()->getRouteParser()
        );
    });

    $container->set(DocumentationController::class, function ($container) {
        return new DocumentationController(
            $container->get("soapServiceRegistry"),
            $container->get("documentationGenerator"),
            $container->get("view")
        );
    });
};

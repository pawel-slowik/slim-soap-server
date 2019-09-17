<?php
declare(strict_types=1);

use Application\Models\SoapService;
use Application\Models\SoapServiceRegistry;
use Application\Models\DocumentationGenerator;
use Application\Controllers\HomeController;
use Application\Controllers\WsdlController;
use Application\Controllers\EndpointController;
use Application\Controllers\DocumentationController;

use Slim\App;

use Domain\Hello;

return function (App $app) {
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

    $container["documentationGenerator"] = function ($container) {
        return new DocumentationGenerator();
    };

    $container["soapServiceRegistry"] = function ($container) {
        $reg = new SoapServiceRegistry();
        $reg->addService("hello", new SoapService(new Hello()));
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

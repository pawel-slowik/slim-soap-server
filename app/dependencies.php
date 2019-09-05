<?php
declare(strict_types=1);

use Application\SoapService;
use Application\SoapServiceRegistry;
use Application\DocumentationGenerator;

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
};

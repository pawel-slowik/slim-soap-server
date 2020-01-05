<?php

declare(strict_types=1);

use Slim\App;
use AutoSoapServer\SoapService\SoapServiceRegistry;
use AutoSoapServer\Controllers\HomeController;
use AutoSoapServer\Controllers\WsdlController;
use AutoSoapServer\Controllers\EndpointController;
use AutoSoapServer\Controllers\DocumentationController;

return function (App $app): void {
    // list of services
    $app->get('/', HomeController::class)->setName('home');
    foreach ($app->getContainer()->get(SoapServiceRegistry::class)->listPaths() as $path) {
        // callable endpoint
        $app->post("/{path:{$path}}", EndpointController::class)->setName('endpoint');
        // WSDL
        $app->get("/{path:{$path}}/wsdl", WsdlController::class)->setName('wsdl');
        // documentation
        $app->get("/{path:{$path}}/doc", DocumentationController::class)->setName('doc');
    }
};

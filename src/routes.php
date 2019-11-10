<?php

declare(strict_types=1);

use Slim\App;
use AutoSoapServer\Controllers\HomeController;
use AutoSoapServer\Controllers\WsdlController;
use AutoSoapServer\Controllers\EndpointController;
use AutoSoapServer\Controllers\DocumentationController;

return function (App $app): void {
    // list of services
    $app->get('/', HomeController::class)->setName('home');

    // callable endpoint
    $app->post('/{path}', EndpointController::class)->setName('endpoint');

    // WSDL
    $app->get('/{path}/wsdl', WsdlController::class)->setName('wsdl');

    // documentation
    $app->get('/{path}/doc', DocumentationController::class)->setName('doc');
};

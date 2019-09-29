<?php

declare(strict_types=1);

use Slim\App;
use Application\Controllers\HomeController;
use Application\Controllers\WsdlController;
use Application\Controllers\EndpointController;
use Application\Controllers\DocumentationController;

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

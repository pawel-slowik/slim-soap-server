<?php

declare(strict_types=1);

use Slim\App;
use Slim\Views\TwigMiddleware;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use AutoSoapServer\ErrorHandlers\HttpNotFoundHandler;
use AutoSoapServer\ErrorHandlers\HttpMethodNotAllowedHandler;

return function (App $app): void {
    $app->add(TwigMiddleware::createFromContainer($app, 'view'));

    $errorMiddleware = $app->addErrorMiddleware(false, true, true);
    $errorMiddleware->setErrorHandler(
        HttpNotFoundException::class,
        HttpNotFoundHandler::class
    );
    $errorMiddleware->setErrorHandler(
        HttpMethodNotAllowedException::class,
        HttpMethodNotAllowedHandler::class
    );
};

<?php

declare(strict_types=1);

use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use AutoSoapServer\ErrorHandlers\HttpNotFoundHandler;
use AutoSoapServer\ErrorHandlers\HttpMethodNotAllowedHandler;

return function (App $app): void {
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));

    $errorMiddleware = $app->addErrorMiddleware(false, true, true);
    $errorMiddleware->setErrorHandler(HttpNotFoundException::class, new HttpNotFoundHandler());
    $errorMiddleware->setErrorHandler(HttpMethodNotAllowedException::class, new HttpMethodNotAllowedHandler());
};

<?php

declare(strict_types=1);

use AutoSoapServer\ErrorHandlers\HttpMethodNotAllowedHandler;
use AutoSoapServer\ErrorHandlers\HttpNotFoundHandler;
use Slim\App;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return function (App $app): void {
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));

    $errorMiddleware = $app->addErrorMiddleware(false, true, true);
    $errorMiddleware->setErrorHandler(HttpNotFoundException::class, new HttpNotFoundHandler());
    $errorMiddleware->setErrorHandler(HttpMethodNotAllowedException::class, new HttpMethodNotAllowedHandler());
};

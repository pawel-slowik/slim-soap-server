<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Views\TwigMiddleware;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Nyholm\Psr7\Response;

return function (App $app): void {
    $app->add(TwigMiddleware::createFromContainer($app, 'view'));

    $errorMiddleware = $app->addErrorMiddleware(false, true, true);

    $errorMiddleware->setErrorHandler(
        HttpNotFoundException::class,
        // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
        function (ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails) {
            $response = new Response();
            $response->getBody()->write('404 NOT FOUND');
            return $response->withStatus(404);
        }
    );

    $errorMiddleware->setErrorHandler(
        HttpMethodNotAllowedException::class,
        // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
        function (ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails) {
            $response = new Response();
            $response->getBody()->write('405 NOT ALLOWED');
            return $response->withStatus(405);
        }
    );
};

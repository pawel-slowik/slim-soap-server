<?php

declare(strict_types=1);

namespace AutoSoapServer\ErrorHandlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Nyholm\Psr7\Response;

class HttpNotFoundHandler
{
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    public function __invoke(Request $request, \Throwable $exception, bool $displayErrorDetails): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write('404 NOT FOUND');
        return $response->withStatus(404);
    }
}

<?php

declare(strict_types=1);

namespace AutoSoapServer\ErrorHandlers;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

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

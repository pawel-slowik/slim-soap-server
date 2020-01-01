<?php

declare(strict_types=1);

namespace AutoSoapServer\ErrorHandlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Nyholm\Psr7\Response;

class HttpMethodNotAllowedHandler
{
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    public function __invoke(Request $request, \Throwable $exception, bool $displayErrorDetails)
    {
        $response = new Response();
        $response->getBody()->write('405 NOT ALLOWED');
        return $response->withStatus(405);
    }
}

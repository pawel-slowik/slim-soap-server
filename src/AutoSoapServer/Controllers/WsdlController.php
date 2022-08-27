<?php

declare(strict_types=1);

namespace AutoSoapServer\Controllers;

use AutoSoapServer\SoapService\SoapServiceRegistry;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteParserInterface;

class WsdlController
{
    public function __construct(
        private SoapServiceRegistry $soapServiceRegistry,
        private RouteParserInterface $routeParser,
    ) {
    }

    public function __invoke(Request $request, Response $response, string $path): Response
    {
        $service = $this->soapServiceRegistry->getServiceForPath($path);
        $endpointUri = $this->routeParser->fullUrlFor($request->getUri(), 'endpoint', ['path' => $path]);
        $wsdl = $service->createWsdlDocument($endpointUri);
        $response->getBody()->write($wsdl->xml);
        return $response->withHeader('Content-Type', "text/xml; charset={$wsdl->encoding}");
    }
}

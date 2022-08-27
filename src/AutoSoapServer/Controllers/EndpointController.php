<?php

declare(strict_types=1);

namespace AutoSoapServer\Controllers;

use AutoSoapServer\SoapService\SoapServiceRegistry;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteParserInterface;

class EndpointController
{
    public function __construct(
        private SoapServiceRegistry $soapServiceRegistry,
        private RouteParserInterface $routeParser,
    ) {
    }

    public function __invoke(Request $request, Response $response, string $path): Response
    {
        $service = $this->soapServiceRegistry->getServiceForPath($path);
        $wsdlUri = $this->routeParser->fullUrlFor($request->getUri(), 'wsdl', ['path' => $path]);
        $endpointUri = $this->routeParser->fullUrlFor($request->getUri(), 'endpoint', ['path' => $path]);
        // TODO: handle SoapFault here?
        $soapResponse = $service->handleSoapMessage($wsdlUri, $endpointUri, (string) $request->getBody());
        $response->getBody()->write($soapResponse);
        return $response->withHeader('Content-Type', 'application/soap+xml');
    }
}

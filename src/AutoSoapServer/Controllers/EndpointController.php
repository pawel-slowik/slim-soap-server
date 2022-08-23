<?php

declare(strict_types=1);

namespace AutoSoapServer\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use AutoSoapServer\SoapService\SoapServiceRegistry;
use Slim\Interfaces\RouteParserInterface;

class EndpointController
{
    private SoapServiceRegistry $soapServiceRegistry;

    private RouteParserInterface $routeParser;

    public function __construct(
        SoapServiceRegistry $soapServiceRegistry,
        RouteParserInterface $routeParser
    ) {
        $this->soapServiceRegistry = $soapServiceRegistry;
        $this->routeParser = $routeParser;
    }

    /**
     * @param array<string, mixed> $args
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $servicePath = $args['path'];
        $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
        $wsdlUri = $this->routeParser->fullUrlFor($request->getUri(), 'wsdl', ['path' => $servicePath]);
        $endpointUri = $this->routeParser->fullUrlFor($request->getUri(), 'endpoint', ['path' => $servicePath]);
        // TODO: handle SoapFault here?
        $soapResponse = $service->handleSoapMessage($wsdlUri, $endpointUri, (string) $request->getBody());
        $response->getBody()->write($soapResponse);
        return $response->withHeader('Content-Type', 'application/soap+xml');
    }
}

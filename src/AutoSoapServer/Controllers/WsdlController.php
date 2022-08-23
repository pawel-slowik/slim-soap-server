<?php

declare(strict_types=1);

namespace AutoSoapServer\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use AutoSoapServer\SoapService\SoapServiceRegistry;
use Slim\Interfaces\RouteParserInterface;

class WsdlController
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
        $endpointUri = $this->routeParser->fullUrlFor($request->getUri(), 'endpoint', ['path' => $servicePath]);
        $wsdl = $service->createWsdlDocument($endpointUri);
        $response->getBody()->write($wsdl->saveXML());
        return $response->withHeader('Content-Type', "text/xml; charset={$wsdl->encoding}");
    }
}

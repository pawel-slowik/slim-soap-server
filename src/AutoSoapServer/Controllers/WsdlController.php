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

<?php

declare(strict_types=1);

namespace AutoSoapServer\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use AutoSoapServer\SoapService\SoapServiceRegistry;
use Slim\Interfaces\RouteParserInterface;

class EndpointController
{
    use PathMixin;

    protected $soapServiceRegistry;

    protected $routeParser;

    public function __construct(
        SoapServiceRegistry $soapServiceRegistry,
        RouteParserInterface $routeParser
    ) {
        $this->soapServiceRegistry = $soapServiceRegistry;
        $this->routeParser = $routeParser;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $servicePath = $args['path'];
        $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
        $wsdlPath = $this->routeParser->relativeUrlFor('wsdl', ['path' => $servicePath]);
        $wsdlUri = $this->urlForPath($request->getUri(), $wsdlPath);
        $endpointPath = $this->routeParser->relativeUrlFor('endpoint', ['path' => $servicePath]);
        $endpointUri = $this->urlForPath($request->getUri(), $endpointPath);
        // TODO: handle SoapFault here?
        $soapResponse = $service->handleSoapMessage($wsdlUri, $endpointUri, (string) $request->getBody());
        $response->getBody()->write($soapResponse);
        return $response->withHeader('Content-Type', 'application/soap+xml');
    }
}

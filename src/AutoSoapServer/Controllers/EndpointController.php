<?php

declare(strict_types=1);

namespace AutoSoapServer\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use AutoSoapServer\SoapService\SoapServiceRegistry;
use Slim\Router;

class EndpointController
{
    use PathMixin;

    protected $soapServiceRegistry;

    protected $router;

    public function __construct(
        SoapServiceRegistry $soapServiceRegistry,
        Router $router
    ) {
        $this->soapServiceRegistry = $soapServiceRegistry;
        $this->router = $router;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $servicePath = $args['path'];
        $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
        $wsdlPath = $this->router->pathFor('wsdl', ['path' => $servicePath]);
        $wsdlUri = $this->urlForPath($request->getUri(), $wsdlPath);
        $endpointPath = $this->router->pathFor('endpoint', ['path' => $servicePath]);
        $endpointUri = $this->urlForPath($request->getUri(), $endpointPath);
        // TODO: handle SoapFault here?
        $soapResponse = $service->handleSoapMessage($wsdlUri, $endpointUri, (string) $request->getBody());
        $response->getBody()->write($soapResponse);
        return $response->withHeader('Content-Type', 'application/soap+xml');
    }
}

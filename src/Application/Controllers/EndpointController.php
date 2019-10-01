<?php

declare(strict_types=1);

namespace Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Application\Models\SoapServiceRegistry;
use Application\Models\SoapServiceNotFoundException;
use Slim\Router;
use Slim\Exception\NotFoundException;

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
        try {
            $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
        } catch (SoapServiceNotFoundException $ex) {
            throw new NotFoundException($request, $response);
        }
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

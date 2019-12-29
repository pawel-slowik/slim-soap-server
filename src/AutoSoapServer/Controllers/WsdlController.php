<?php

declare(strict_types=1);

namespace AutoSoapServer\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use AutoSoapServer\SoapService\SoapServiceRegistry;
use Slim\Router;

class WsdlController
{
    use PathMixin;

    protected $soapServiceRegistry;

    protected $router;

    public function __construct(SoapServiceRegistry $soapServiceRegistry, Router $router)
    {
        $this->soapServiceRegistry = $soapServiceRegistry;
        $this->router = $router;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $servicePath = $args['path'];
        $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
        $endpointPath = $this->router->pathFor('endpoint', ['path' => $servicePath]);
        $endpointUri = $this->urlForPath($request->getUri(), $endpointPath);
        $wsdl = $service->createWsdlDocument($endpointUri);
        $encoding = $wsdl->encoding;
        $response->getBody()->write($wsdl->saveXML());
        return $response->withHeader('Content-Type', "text/xml; charset={$encoding}");
    }
}

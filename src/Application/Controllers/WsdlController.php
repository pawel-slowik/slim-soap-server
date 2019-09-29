<?php

declare(strict_types=1);

namespace Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Application\Controllers\PathController;
use Application\Models\SoapServiceRegistry;
use Application\Models\SoapServiceNotFoundException;
use Slim\Router;
use Slim\Exception\NotFoundException;

class WsdlController
{
    use PathController;

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
        try {
            $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
        } catch (SoapServiceNotFoundException $ex) {
            throw new NotFoundException($request, $response);
        }
        $endpointPath = $this->router->pathFor('endpoint', ['path' => $servicePath]);
        $endpointUri = $this->urlForPath($request->getUri(), $endpointPath);
        $wsdl = $service->createWsdlDocument($endpointUri);
        $encoding = $wsdl->encoding;
        $response->getBody()->write($wsdl->saveXML());
        return $response->withHeader('Content-Type', "text/xml; charset=$encoding");
    }
}

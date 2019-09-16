<?php
declare(strict_types=1);

namespace Application;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Application\SoapServiceRegistry;
use Slim\Router;

class WsdlController
{
    protected $soapServiceRegistry;

    protected $router;

    public function __construct(SoapServiceRegistry $soapServiceRegistry, Router $router) {
        $this->soapServiceRegistry = $soapServiceRegistry;
        $this->router = $router;
    }

    public function __invoke(Request $request, Response $response, array $args) {
        $servicePath = $args['path'];
        try {
            $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
        } catch (RuntimeException $ex) {
            return ($this->notFoundHandler)($request, $response);
        }
        $endpointPath = $this->router->pathFor('endpoint', ['path' => $servicePath]);
        $endpointUri = $service->urlForPath($request->getUri(), $endpointPath);
        $wsdl = $service->createWsdlDocument($endpointUri);
        $encoding = $wsdl->encoding;
        $response->getBody()->write($wsdl->saveXML());
        return $response->withHeader('Content-Type', "text/xml; charset=$encoding");
    }
}

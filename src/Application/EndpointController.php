<?php
declare(strict_types=1);

namespace Application;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Application\SoapServiceRegistry;
use Slim\Router;

class EndpointController
{
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
        } catch (RuntimeException $ex) {
            return ($this->notFoundHandler)($request, $response);
        }
        $wsdlPath = $this->router->pathFor('wsdl', ['path' => $servicePath]);
        $wsdlUri = $service->urlForPath($request->getUri(), $wsdlPath);
        // TODO: handle SoapFault here?
        $soapResponse = $service->handleSoapMessage($wsdlUri, (string)$request->getBody());
        $response->getBody()->write($soapResponse);
        return $response->withHeader('Content-Type', 'application/soap+xml');
    }
}

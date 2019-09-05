<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Slim\App;

return function (App $app) {
    // list of services
    $app->get(
        '/',
        // TODO: move to a controller class
        function (Request $request, Response $response, array $args) {
            $services = [];
            foreach ($this->soapServiceRegistry->listPaths() as $path) {
                $service = $this->soapServiceRegistry->getServiceForPath($path);
                $services[] = [
                    'name' => $service->getName(),
                    'description' => $service->getDescription(),
                    'path' => $path,
                ];
            }
            $templateData = ['services' => $services];
            return $this->view->render($response, 'home.html', $templateData);
        }
    )->setName('home');

    // callable endpoint
    $app->post(
        '/{path}',
        // TODO: move to a controller class
        function (Request $request, Response $response, array $args) {
            $servicePath = $args['path'];
            // TODO: handle invalid $path with a 404
            // TODO: handle SoapFault here?
            $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
            $wsdlPath = $this->router->pathFor('wsdl', ['path' => $servicePath]);
            $wsdlUri = $service->urlForPath($request->getUri(), $wsdlPath);
            $soapResponse = $service->handleSoapMessage($wsdlUri, (string)$request->getBody());
            $response->getBody()->write($soapResponse);
            return $response->withHeader('Content-Type', 'application/soap+xml');
        }
    )->setName('endpoint');

    // WSDL
    $app->get(
        '/{path}/wsdl',
        // TODO: move to a controller class
        function (Request $request, Response $response, array $args) {
            $servicePath = $args['path'];
            // TODO: handle invalid $path with a 404
            $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
            $endpointPath = $this->router->pathFor('endpoint', ['path' => $servicePath]);
            $endpointUri = $service->urlForPath($request->getUri(), $endpointPath);
            $wsdl = $service->createWsdlDocument($endpointUri);
            $encoding = $wsdl->encoding;
            $response->getBody()->write($wsdl->saveXML());
            return $response->withHeader('Content-Type', "text/xml; charset=$encoding");
        }
    )->setName('wsdl');

    // documentation
    $app->get(
        '/{path}/doc',
        // TODO: move to a controller class
        function (Request $request, Response $response, array $args) {
            $servicePath = $args['path'];
            // TODO: handle invalid $path with a 404
            $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
            $templateData = [
                'name' => $service->getName(),
                'doc' => $this->documentationGenerator->createDocumentation(
                    $service->getImplementation()
                ),
            ];
            return $this->view->render($response, 'doc.html', $templateData);
        }
    )->setName('doc');
};

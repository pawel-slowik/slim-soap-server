<?php

declare(strict_types=1);

namespace AutoSoapServer\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use AutoSoapServer\Documentation\DocumentationGenerator;
use AutoSoapServer\Models\SoapServiceRegistry;
use AutoSoapServer\Models\SoapServiceNotFoundException;
use Slim\Views\Twig as View;
use Slim\Exception\NotFoundException;

class DocumentationController
{
    protected $soapServiceRegistry;

    protected $documentationGenerator;

    protected $view;

    public function __construct(
        SoapServiceRegistry $soapServiceRegistry,
        DocumentationGenerator $documentationGenerator,
        View $view
    ) {
        $this->soapServiceRegistry = $soapServiceRegistry;
        $this->documentationGenerator = $documentationGenerator;
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $servicePath = $args['path'];
        try {
            $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
        } catch (SoapServiceNotFoundException $ex) {
            throw new NotFoundException($request, $response);
        }
        $documentedService = $this->documentationGenerator->createDocumentation($service);
        $templateData = ["service" => $documentedService];
        return $this->view->render($response, 'doc.html', $templateData)->
            withHeader("Content-Type", "text/html; charset=UTF-8");
    }
}

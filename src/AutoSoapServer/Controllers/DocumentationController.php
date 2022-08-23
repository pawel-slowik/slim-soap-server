<?php

declare(strict_types=1);

namespace AutoSoapServer\Controllers;

use AutoSoapServer\Documentation\DocumentationGenerator;
use AutoSoapServer\SoapService\SoapServiceRegistry;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig as View;

class DocumentationController
{
    private SoapServiceRegistry $soapServiceRegistry;

    private DocumentationGenerator $documentationGenerator;

    private View $view;

    public function __construct(
        SoapServiceRegistry $soapServiceRegistry,
        DocumentationGenerator $documentationGenerator,
        View $view
    ) {
        $this->soapServiceRegistry = $soapServiceRegistry;
        $this->documentationGenerator = $documentationGenerator;
        $this->view = $view;
    }

    /**
     * @param array<string, mixed> $args
     */
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $servicePath = $args['path'];
        $service = $this->soapServiceRegistry->getServiceForPath($servicePath);
        $documentedService = $this->documentationGenerator->createDocumentation($service);
        $templateData = ["service" => $documentedService];
        return $this->view->render($response, 'doc.html', $templateData)->
            withHeader("Content-Type", "text/html; charset=UTF-8");
    }
}

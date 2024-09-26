<?php

declare(strict_types=1);

namespace AutoSoapServer\Controllers;

use AutoSoapServer\Documentation\DocumentationGenerator;
use AutoSoapServer\SoapService\SoapServiceRegistry;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig as View;

final readonly class DocumentationController
{
    public function __construct(
        private SoapServiceRegistry $soapServiceRegistry,
        private DocumentationGenerator $documentationGenerator,
        private View $view,
    ) {
    }

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    public function __invoke(Request $request, Response $response, string $path): Response
    {
        $service = $this->soapServiceRegistry->getServiceForPath($path);
        $documentedService = $this->documentationGenerator->createDocumentation($service);
        $templateData = ["service" => $documentedService];
        return $this->view
            ->render($response, 'doc.html', $templateData)
            ->withHeader("Content-Type", "text/html; charset=UTF-8");
    }
}

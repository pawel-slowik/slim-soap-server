<?php

declare(strict_types=1);

namespace AutoSoapServer\Controllers;

use AutoSoapServer\SoapService\SoapServiceRegistry;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig as View;

final readonly class HomeController
{
    public function __construct(
        private SoapServiceRegistry $soapServiceRegistry,
        private View $view,
    ) {
    }

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    public function __invoke(Request $request, Response $response): Response
    {
        $services = [];
        foreach ($this->soapServiceRegistry->listPaths() as $path) {
            $service = $this->soapServiceRegistry->getServiceForPath($path);
            $services[] = [
                "name" => $service->getName(),
                "description" => $service->getDescription(),
                "path" => $path,
            ];
        }
        $templateData = ["services" => $services];
        return $this->view
            ->render($response, "home.html", $templateData)
            ->withHeader("Content-Type", "text/html; charset=UTF-8");
    }
}

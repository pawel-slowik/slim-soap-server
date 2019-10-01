<?php

declare(strict_types=1);

namespace Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Application\Models\SoapServiceRegistry;
use Slim\Views\Twig as View;

class HomeController
{
    protected $soapServiceRegistry;

    protected $view;

    public function __construct(
        SoapServiceRegistry $soapServiceRegistry,
        View $view
    ) {
        $this->soapServiceRegistry = $soapServiceRegistry;
        $this->view = $view;
    }

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    public function __invoke(Request $request, Response $response, array $args)
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
        return $this->view->render($response, "home.html", $templateData)->
            withHeader("Content-Type", "text/html; charset=UTF-8");
    }
}

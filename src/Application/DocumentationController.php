<?php
declare(strict_types=1);

namespace Application;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Application\SoapServiceRegistry;
use Application\DocumentationGenerator;
use Slim\Views\Twig as View;

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
        } catch (RuntimeException $ex) {
            return ($this->notFoundHandler)($request, $response);
        }
        $templateData = [
            'name' => $service->getName(),
            'doc' => $this->documentationGenerator->createDocumentation(
                $service->getImplementation()
            ),
        ];
        return $this->view->render($response, 'doc.html', $templateData);
    }
}

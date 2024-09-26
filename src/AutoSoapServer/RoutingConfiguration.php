<?php

declare(strict_types=1);

namespace AutoSoapServer;

use AutoSoapServer\Controllers\DocumentationController;
use AutoSoapServer\Controllers\EndpointController;
use AutoSoapServer\Controllers\HomeController;
use AutoSoapServer\Controllers\WsdlController;
use AutoSoapServer\SoapService\SoapServiceRegistry;
use DI\Container;
use Slim\App;
use Slim\Handlers\Strategies\RequestResponseArgs;

class RoutingConfiguration
{
    private SoapServiceRegistry $soapServiceRegistry;

    public function __construct(SoapServiceRegistry $soapServiceRegistry)
    {
        $this->soapServiceRegistry = $soapServiceRegistry;
    }

    /**
     * @param App<Container> $app
     *
     * @return App<Container>
     */
    public function apply(App $app): App
    {
        $strategy = new RequestResponseArgs();
        $app->get("/", HomeController::class)
            ->setName("home")
            ->setInvocationStrategy($strategy);
        foreach ($this->soapServiceRegistry->listPaths() as $path) {
            $app->post("/{path:{$path}}", EndpointController::class)
                ->setName("endpoint")
                ->setInvocationStrategy($strategy);
            $app->get("/{path:{$path}}/wsdl", WsdlController::class)
                ->setName("wsdl")
                ->setInvocationStrategy($strategy);
            $app->get("/{path:{$path}}/doc", DocumentationController::class)
                ->setName("doc")
                ->setInvocationStrategy($strategy);
        }
        return $app;
    }
}

<?php

declare(strict_types=1);

namespace AutoSoapServer;

use Slim\App;
use AutoSoapServer\SoapService\SoapServiceRegistry;
use AutoSoapServer\Controllers\HomeController;
use AutoSoapServer\Controllers\WsdlController;
use AutoSoapServer\Controllers\EndpointController;
use AutoSoapServer\Controllers\DocumentationController;

class RoutingConfiguration
{
    private $soapServiceRegistry;

    public function __construct(SoapServiceRegistry $soapServiceRegistry)
    {
        $this->soapServiceRegistry = $soapServiceRegistry;
    }

    public function apply(App $app): App
    {
        $app->get("/", HomeController::class)->setName("home");
        foreach ($this->soapServiceRegistry->listPaths() as $path) {
            $app->post("/{path:{$path}}", EndpointController::class)->setName("endpoint");
            $app->get("/{path:{$path}}/wsdl", WsdlController::class)->setName("wsdl");
            $app->get("/{path:{$path}}/doc", DocumentationController::class)->setName("doc");
        }
        return $app;
    }
}

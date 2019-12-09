<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Zend\Code\Reflection\ClassReflection;
use AutoSoapServer\Models\SoapService;

class DocumentationGenerator
{
    public function createDocumentation(SoapService $service): DocumentedService
    {
        return new DocumentedService(
            $service->getName(),
            new ClassReflection($service->getImplementation())
        );
    }
}
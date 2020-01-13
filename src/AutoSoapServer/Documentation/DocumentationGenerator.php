<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\ClassReflection;
use AutoSoapServer\SoapService\SoapService;

class DocumentationGenerator
{
    public function createDocumentation(SoapService $service): DocumentedService
    {
        return new DocumentedService(
            $service->getName(),
            new ClassReflection($service->getImplementation()),
            $service->discoverComplexTypes()
        );
    }
}

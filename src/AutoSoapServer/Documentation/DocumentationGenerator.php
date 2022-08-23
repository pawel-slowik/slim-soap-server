<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use AutoSoapServer\SoapService\SoapService;
use Laminas\Code\Reflection\ClassReflection;

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

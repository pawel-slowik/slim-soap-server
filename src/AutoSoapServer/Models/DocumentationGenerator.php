<?php

declare(strict_types=1);

namespace AutoSoapServer\Models;

use Zend\Code\Reflection\ClassReflection;

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

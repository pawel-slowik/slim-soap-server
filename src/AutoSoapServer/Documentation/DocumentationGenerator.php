<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use AutoSoapServer\SoapService\ComplexTypeStrategySpy;
use AutoSoapServer\SoapService\SoapService;
use Laminas\Code\Reflection\ClassReflection;
use Laminas\Soap\AutoDiscover;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\DefaultComplexType;

class DocumentationGenerator
{
    public function __construct(
        private readonly ComplexTypesGenerator $complexTypesGenerator,
    ) {
    }

    public function createDocumentation(SoapService $service): DocumentedService
    {
        return DocumentedService::fromClassReflection(
            $service->getName(),
            new ClassReflection($service->getImplementation()),
            $this->discoverComplexTypes($service->getImplementation()),
        );
    }

    /**
     * @return class-string[]
     */
    public function discoverComplexTypes(object $implementation): array
    {
        $spy = new ComplexTypeStrategySpy(new DefaultComplexType());
        $autodiscover = new AutoDiscover($spy);
        $autodiscover->setClass($implementation::class);
        $autodiscover->setUri("dummy");
        $autodiscover->generate();
        return $this->complexTypesGenerator->generate($spy->getSpiedTypes());
    }
}

<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use AutoSoapServer\SoapService\ComplexTypeStrategySpy;
use Laminas\Code\Reflection\ClassReflection;
use Laminas\Soap\AutoDiscover;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\DefaultComplexType;

class DocumentationGenerator
{
    public function __construct(
        private readonly ComplexTypesGenerator $complexTypesGenerator,
    ) {
    }

    public function createDocumentation(string $name, object $service): DocumentedService
    {
        return DocumentedService::fromClassReflection(
            $name,
            new ClassReflection($service),
            $this->discoverComplexTypes($service),
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

<?php

declare(strict_types=1);

namespace AutoSoapServer\SoapService;

use Laminas\Soap\Wsdl;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\ComplexTypeStrategyInterface;

class ComplexTypeStrategySpy implements ComplexTypeStrategyInterface
{
    private $spiedStrategy;

    private $spiedTypeMap;

    public function __construct(ComplexTypeStrategyInterface $strategy)
    {
        $this->spiedStrategy = $strategy;
        $this->spiedTypeMap = [];
    }

    public function setContext(Wsdl $context): void
    {
        $this->spiedStrategy->setContext($context);
    }

    public function addComplexType($type)
    {
        $mapped = $this->spiedStrategy->addComplexType($type);
        $this->spiedTypeMap[$type] = $mapped;
        return $mapped;
    }

    public function getTypeMap(): array
    {
        return array_combine(
            array_keys($this->spiedTypeMap),
            array_map([$this, "stripNamespace"], $this->spiedTypeMap)
        );
    }

    public function getClassMap(): array
    {
        return array_flip($this->getTypeMap());
    }

    private static function stripNamespace(string $type): string
    {
        return explode(":", $type, 2)[1];
    }
}

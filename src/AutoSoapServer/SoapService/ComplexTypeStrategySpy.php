<?php

declare(strict_types=1);

namespace AutoSoapServer\SoapService;

use Laminas\Soap\Wsdl;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\ComplexTypeStrategyInterface;

class ComplexTypeStrategySpy implements ComplexTypeStrategyInterface
{
    /**
     * @var MappedComplexType[]
     */
    private array $spiedTypes;

    public function __construct(private readonly ComplexTypeStrategyInterface $spiedStrategy)
    {
        $this->spiedTypes = [];
    }

    public function setContext(Wsdl $context): void
    {
        $this->spiedStrategy->setContext($context);
    }

    /**
     * @param class-string $type
     */
    public function addComplexType($type)
    {
        $mapped = $this->spiedStrategy->addComplexType($type);
        $this->spiedTypes[] = new MappedComplexType($type, $mapped);
        return $mapped;
    }

    /**
     * @return MappedComplexType[]
     */
    public function getSpiedTypes(): array
    {
        return $this->spiedTypes;
    }
}

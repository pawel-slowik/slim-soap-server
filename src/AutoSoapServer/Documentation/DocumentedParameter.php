<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Zend\Code\Reflection\ParameterReflection;
use Zend\Code\Reflection\DocBlockReflection;

class DocumentedParameter
{
    /** @var string */
    public $name;

    /** @var \ReflectionType|null */
    public $type;

    /** @var string|null */
    public $defaultValue;

    /** @var string|null */
    public $description;

    /** @var bool */
    public $isNullable;

    /** @var bool */
    public $isOptional;

    public function __construct(ParameterReflection $parameter)
    {
        $this->name = $parameter->name;
        $this->type = $parameter->getType();
        $this->description = $this->getDescription($parameter);
        $this->defaultValue = $this->getDefaultValue($parameter);
        $this->isNullable = $parameter->allowsNull();
        $this->isOptional = $parameter->isOptional();
    }

    protected function getDescription(ParameterReflection $parameter): ?string
    {
        $methodDocBlock = $parameter->getDeclaringFunction()->getDocBlock();
        if (!($methodDocBlock instanceof DocBlockReflection)) {
            return null;
        }
        $parameterTags = $methodDocBlock->getTags('param');
        if (!array_key_exists($parameter->getPosition(), $parameterTags)) {
            return null;
        }
        $parameterTag = $parameterTags[$parameter->getPosition()];
        return $parameterTag->getDescription();
    }

    protected function getDefaultValue(ParameterReflection $parameter): ?string
    {
        if (!$parameter->isDefaultValueAvailable()) {
            return null;
        }
        if ($parameter->isDefaultValueConstant()) {
            return $parameter->getDefaultValueConstantName();
        }
        return var_export($parameter->getDefaultValue(), true);
    }
}

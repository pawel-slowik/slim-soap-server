<?php

declare(strict_types=1);

namespace Application\Models;

use Zend\Code\Reflection\ParameterReflection;
use Zend\Code\Reflection\DocBlockReflection;

class DocumentedParameter
{
    public $name;

    public $type;

    public $defaultValue;

    public $description;

    public $isNullable;

    public $isOptional;

    public function __construct(ParameterReflection $parameter)
    {
        $this->name = $parameter->name;
        $this->type = $parameter->detectType();
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

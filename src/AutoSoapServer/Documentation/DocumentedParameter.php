<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\DocBlock\Tag\ParamTag;
use Laminas\Code\Reflection\DocBlockReflection;
use Laminas\Code\Reflection\ParameterReflection;
use ReflectionNamedType;

class DocumentedParameter
{
    public readonly string $name;

    public readonly ?string $type;

    public readonly ?string $defaultValue;

    public readonly ?string $description;

    public readonly bool $isNullable;

    public readonly bool $isOptional;

    public function __construct(ParameterReflection $parameter)
    {
        $this->name = $parameter->name;
        $type = $parameter->getType();
        $this->type = ($type instanceof ReflectionNamedType) ? $type->getName() : null;
        $this->description = $this->getDescription($parameter);
        $this->defaultValue = $this->getDefaultValue($parameter);
        $this->isNullable = $parameter->allowsNull();
        $this->isOptional = $parameter->isOptional();
    }

    private function getDescription(ParameterReflection $parameter): ?string
    {
        $methodDocBlock = $parameter->getDeclaringFunction()->getDocBlock();
        if (!($methodDocBlock instanceof DocBlockReflection)) {
            return null;
        }
        $parameterTags = $methodDocBlock->getTags('param');
        if (!array_key_exists($parameter->getPosition(), $parameterTags)) {
            return null;
        }
        /** @var ParamTag $parameterTag */
        $parameterTag = $parameterTags[$parameter->getPosition()];
        return $parameterTag->getDescription();
    }

    private function getDefaultValue(ParameterReflection $parameter): ?string
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

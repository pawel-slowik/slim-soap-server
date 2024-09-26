<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\DocBlock\Tag\ParamTag;
use Laminas\Code\Reflection\DocBlockReflection;
use Laminas\Code\Reflection\ParameterReflection;
use ReflectionNamedType;

readonly class DocumentedParameter
{
    public function __construct(
        public string $name,
        public ?string $type,
        public ?string $defaultValue,
        public ?string $description,
        public bool $isNullable,
        public bool $isOptional,
    ) {
    }

    public static function fromParameterReflection(ParameterReflection $parameter): self
    {
        $type = $parameter->getType();

        return new self(
            $parameter->name,
            $type instanceof ReflectionNamedType ? $type->getName() : null,
            self::getDefaultValue($parameter),
            self::getDescription($parameter),
            $parameter->allowsNull(),
            $parameter->isOptional(),
        );
    }

    private static function getDescription(ParameterReflection $parameter): ?string
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

    private static function getDefaultValue(ParameterReflection $parameter): ?string
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

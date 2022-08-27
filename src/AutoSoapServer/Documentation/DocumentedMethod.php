<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\DocBlock\Tag\ReturnTag;
use Laminas\Code\Reflection\DocBlockReflection;
use Laminas\Code\Reflection\MethodReflection;
use Laminas\Code\Reflection\ParameterReflection;
use ReflectionNamedType;

class DocumentedMethod
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $shortDescription,
        public readonly ?string $longDescription,
        /** @var DocumentedParameter[] */
        public readonly array $parameters,
        public readonly ?string $returnType,
        public readonly ?string $returnDescription,
    ) {
    }

    public static function fromMethodReflection(MethodReflection $methodReflection): self
    {
        $docBlock = $methodReflection->getDocBlock();
        if ($docBlock) {
            $shortDescription = $docBlock->getShortDescription();
            $longDescription = $docBlock->getLongDescription();
        } else {
            $shortDescription = null;
            $longDescription = null;
        }

        $parameters = $methodReflection->getParameters();
        usort(
            $parameters,
            fn (ParameterReflection $a, ParameterReflection $b): int => $a->getPosition() - $b->getPosition(),
        );
        $parameters = array_map(
            fn (ParameterReflection $parameter): DocumentedParameter => DocumentedParameter::fromParameterReflection($parameter),
            $parameters,
        );

        $returnType = $methodReflection->getReturnType();
        $returnTypeName = ($returnType instanceof ReflectionNamedType) ? $returnType->getName() : null;

        return new self(
            $methodReflection->getShortName(),
            $shortDescription,
            $longDescription,
            $parameters,
            $returnTypeName,
            self::getReturnDescription($methodReflection),
        );
    }

    private static function getReturnDescription(MethodReflection $method): ?string
    {
        $methodDocBlock = $method->getDocBlock();
        if (!($methodDocBlock instanceof DocBlockReflection)) {
            return null;
        }
        $returnTags = $methodDocBlock->getTags('return');
        if (!$returnTags) {
            return null;
        }
        /** @var ReturnTag $returnTag */
        $returnTag = $returnTags[0];
        return $returnTag->getDescription();
    }
}

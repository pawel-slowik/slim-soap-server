<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\DocBlock\Tag\ReturnTag;
use Laminas\Code\Reflection\DocBlockReflection;
use Laminas\Code\Reflection\MethodReflection;
use Laminas\Code\Reflection\ParameterReflection;
use ReflectionNamedType;

readonly class DocumentedMethod
{
    public function __construct(
        public string $name,
        public ?string $shortDescription,
        public ?string $longDescription,
        /** @var DocumentedParameter[] */
        public array $parameters,
        public ?string $returnType,
        public ?string $returnDescription,
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
            DocumentedParameter::fromParameterReflection(...),
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

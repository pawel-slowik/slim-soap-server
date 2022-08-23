<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\DocBlock\Tag\ReturnTag;
use Laminas\Code\Reflection\DocBlockReflection;
use Laminas\Code\Reflection\MethodReflection;
use Laminas\Code\Reflection\ParameterReflection;

class DocumentedMethod
{
    public readonly string $name;

    public readonly ?string $shortDescription;

    public readonly ?string $longDescription;

    /** @var DocumentedParameter[] */
    public readonly array $parameters;

    public readonly ?string $returnType;

    public readonly ?string $returnDescription;

    public function __construct(MethodReflection $method)
    {
        $docBlock = $method->getDocBlock();
        $this->name = $method->getShortName();
        if ($docBlock) {
            $this->shortDescription = $docBlock->getShortDescription();
            $this->longDescription = $docBlock->getLongDescription();
        } else {
            $this->shortDescription = null;
            $this->longDescription = null;
        }
        $returnType = $method->getReturnType();
        $this->returnType = ($returnType instanceof \ReflectionNamedType) ? $returnType->getName() : null;
        $this->returnDescription = $this->getReturnDescription($method);
        $parameters = $method->getParameters();
        usort(
            $parameters,
            function ($a, $b) {
                return $a->getPosition() - $b->getPosition();
            }
        );
        $this->parameters = array_map(
            fn (ParameterReflection $parameter): DocumentedParameter => new DocumentedParameter($parameter),
            $parameters,
        );
    }

    private function getReturnDescription(MethodReflection $method): ?string
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

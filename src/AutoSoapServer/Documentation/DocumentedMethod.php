<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\MethodReflection;
use Laminas\Code\Reflection\DocBlockReflection;
use Laminas\Code\Reflection\DocBlock\Tag\ReturnTag;

class DocumentedMethod
{
    /** @var string */
    public $name;

    /** @var string|null */
    public $shortDescription;

    /** @var string|null */
    public $longDescription;

    /** @var DocumentedParameter[] */
    public $parameters;

    /** @var string|null */
    public $returnType;

    /** @var string|null */
    public $returnDescription;

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
        $this->parameters = [];
        foreach ($parameters as $parameter) {
            $this->parameters[] = new DocumentedParameter($parameter);
        }
    }

    protected function getReturnDescription(MethodReflection $method): ?string
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

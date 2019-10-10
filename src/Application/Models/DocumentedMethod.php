<?php

declare(strict_types=1);

namespace Application\Models;

use Zend\Code\Reflection\MethodReflection;
use Zend\Code\Reflection\DocBlockReflection;

class DocumentedMethod
{
    public $name;

    public $shortDescription;

    public $longDescription;

    public $parameters;

    public $returnType;

    public $returnDescription;

    public function __construct(MethodReflection $method)
    {
        $docBlock = $method->getDocBlock();
        $this->name = $method->getShortName();
        $this->shortDescription = $docBlock->getShortDescription();
        $this->longDescription = $docBlock->getLongDescription();
        $this->returnType = $method->getReturnType();
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
        $returnTag = $returnTags[0];
        return $returnTag->getDescription();
    }
}

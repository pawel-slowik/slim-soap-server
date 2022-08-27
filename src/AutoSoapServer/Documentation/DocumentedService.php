<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\ClassReflection;
use Laminas\Code\Reflection\MethodReflection;
use ReflectionMethod;

class DocumentedService
{
    public readonly string $name;

    public readonly ?string $shortDescription;

    public readonly ?string $longDescription;

    /** @var DocumentedMethod[] */
    public readonly array $methods;

    /** @var DocumentedType[] */
    public readonly array $types;

    /**
     * @param string[] $complexTypeNames
     */
    public function __construct(string $name, ClassReflection $class, array $complexTypeNames)
    {
        $this->name = $name;
        $docBlock = $class->getDocBlock();
        $reflectedMethods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        if ($docBlock) {
            $this->shortDescription = $docBlock->getShortDescription();
            $this->longDescription = $docBlock->getLongDescription();
        } else {
            $this->shortDescription = null;
            $this->longDescription = null;
        }
        $this->methods = array_map(
            fn (MethodReflection $m): DocumentedMethod => new DocumentedMethod($m),
            $reflectedMethods
        );
        $this->types = array_map(
            fn (string $t): DocumentedType => new DocumentedType($t),
            $complexTypeNames
        );
    }
}

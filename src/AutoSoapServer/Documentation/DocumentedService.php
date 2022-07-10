<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\ClassReflection;

class DocumentedService
{
    /** @var string */
    public $name;

    /** @var string|null */
    public $shortDescription;

    /** @var string|null */
    public $longDescription;

    /** @var DocumentedMethod[] */
    public $methods;

    /** @var DocumentedType[] */
    public $types;

    /**
     * @param string[] $complexTypeNames
     */
    public function __construct(string $name, ClassReflection $class, array $complexTypeNames)
    {
        $this->name = $name;
        $docBlock = $class->getDocBlock();
        $reflectedMethods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        if ($docBlock) {
            $this->shortDescription = $docBlock->getShortDescription();
            $this->longDescription = $docBlock->getLongDescription();
        } else {
            $this->shortDescription = null;
            $this->longDescription = null;
        }
        $this->methods = array_map(
            function ($m) {
                return new DocumentedMethod($m);
            },
            $reflectedMethods
        );
        $this->types = array_map(
            function ($t) {
                return new DocumentedType($t);
            },
            $complexTypeNames
        );
    }
}

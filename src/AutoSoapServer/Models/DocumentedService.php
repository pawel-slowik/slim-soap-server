<?php

declare(strict_types=1);

namespace AutoSoapServer\Models;

use Zend\Code\Reflection\ClassReflection;

class DocumentedService
{
    public $name;

    public $shortDescription;

    public $longDescription;

    public $methods;

    public function __construct(string $name, ClassReflection $class)
    {
        $this->name = $name;
        $docBlock = $class->getDocBlock();
        $serviceDescription = $class->getDocComment();
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
        // TODO: generate documentation for datatypes
    }
}

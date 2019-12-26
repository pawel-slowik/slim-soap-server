<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Reflection\MethodReflection;

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

    public function __construct(string $name, ClassReflection $class)
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
            $this->listComplexTypes($reflectedMethods)
        );
    }

    private static function listComplexTypes(iterable $methods): iterable
    {
        return array_filter(
            iterator_to_array(self::listTypes($methods), false),
            function ($type) {
                return !$type->isBuiltin();
            }
        );
    }

    private static function listTypes(iterable $methods): iterable
    {
        foreach ($methods as $documentedMethod) {
            yield from self::listMethodTypes($documentedMethod);
        }
    }

    private static function listMethodTypes(MethodReflection $reflectedMethod): iterable
    {
        // TODO: make it recursive
        yield from array_map(
            function ($reflectedParameter) {
                return $reflectedParameter->getType();
            },
            $reflectedMethod->getParameters()
        );
        yield $reflectedMethod->getReturnType();
    }
}

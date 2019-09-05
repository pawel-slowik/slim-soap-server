<?php
declare(strict_types=1);

namespace Application;

use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Reflection\MethodReflection;

class DocumentationGenerator
{

    // TODO: generate documentation for datatypes

    public function createDocumentation(object $subject): array
    {
        $reflectedClass = new ClassReflection($subject);
        $reflectedMethods = $reflectedClass->getMethods(\ReflectionMethod::IS_PUBLIC);
        $doc = [
            'methods' => [],
        ];
        // TODO: use simple objects with public properties instead of arrays
        foreach ($reflectedMethods as $method) {
            $doc['methods'][] = [
                'name' => $method->getShortName(),
                'docblock' => $method->getDocComment(),
                'prototype' => $method->getPrototype(MethodReflection::PROTOTYPE_AS_STRING),
            ];
        }
        return $doc;
    }

}

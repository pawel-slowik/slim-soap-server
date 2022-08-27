<?php

declare(strict_types=1);

namespace Test\Documentation;

use Laminas\Code\Reflection\ClassReflection;
use Laminas\Code\Reflection\MethodReflection;
use Laminas\Code\Reflection\ParameterReflection;
use LogicException;
use PHPUnit\Framework\TestCase;

abstract class DocumentedTestBase extends TestCase
{
    protected function getReflectedMethod(
        string $className,
        string $methodName
    ): MethodReflection {
        $classReflection = new ClassReflection($className);
        $matchingMethodReflections = array_values(array_filter(
            $classReflection->getMethods(),
            fn (MethodReflection $m): bool => $m->getShortName() === $methodName,
        ));
        if (count($matchingMethodReflections) !== 1) {
            throw new LogicException();
        }
        return $matchingMethodReflections[0];
    }

    protected function getReflectedParameter(
        string $className,
        string $methodName,
        string $parameterName
    ): ParameterReflection {
        $methodReflection = $this->getReflectedMethod($className, $methodName);
        $matchingParameterReflections = array_values(array_filter(
            $methodReflection->getParameters(),
            fn (ParameterReflection $p): bool => $p->name === $parameterName,
        ));
        if (count($matchingParameterReflections) !== 1) {
            throw new LogicException();
        }
        return $matchingParameterReflections[0];
    }
}

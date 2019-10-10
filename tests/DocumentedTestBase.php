<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;

use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Reflection\MethodReflection;
use Zend\Code\Reflection\ParameterReflection;

abstract class DocumentedTestBase extends TestCase
{
    protected function getReflectedMethod(
        string $className,
        string $methodName
    ): MethodReflection {
        $classReflection = new ClassReflection($className);
        $matchingMethodReflections = array_values(array_filter(
            $classReflection->getMethods(),
            function ($m) use ($methodName) {
                return $m->getShortName() === $methodName;
            }
        ));
        if (count($matchingMethodReflections) !== 1) {
            throw new \LogicException();
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
            function ($p) use ($parameterName) {
                return $p->name === $parameterName;
            }
        ));
        if (count($matchingParameterReflections) !== 1) {
            throw new \LogicException();
        }
        return $matchingParameterReflections[0];
    }
}

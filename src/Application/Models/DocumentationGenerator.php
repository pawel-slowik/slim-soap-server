<?php

declare(strict_types=1);

namespace Application\Models;

use Zend\Code\Reflection\ClassReflection;

class DocumentationGenerator
{
    public function createDocumentation(string $name, object $subject): DocumentedService
    {
        return new DocumentedService($name, new ClassReflection($subject));
    }
}

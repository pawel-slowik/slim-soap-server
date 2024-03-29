<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\ClassReflection;
use ReflectionMethod;

class DocumentedService
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $shortDescription,
        public readonly ?string $longDescription,
        /** @var DocumentedMethod[] */
        public readonly array $methods,
        /** @var DocumentedType[] */
        public readonly array $types,
    ) {
    }

    /**
     * @param class-string[] $complexTypeNames
     */
    public static function fromClassReflection(string $name, ClassReflection $class, array $complexTypeNames): self
    {
        $docBlock = $class->getDocBlock();
        if ($docBlock) {
            $shortDescription = $docBlock->getShortDescription();
            $longDescription = $docBlock->getLongDescription();
        } else {
            $shortDescription = null;
            $longDescription = null;
        }

        return new self(
            $name,
            $shortDescription,
            $longDescription,
            array_map(
                DocumentedMethod::fromMethodReflection(...),
                $class->getMethods(ReflectionMethod::IS_PUBLIC),
            ),
            array_map(
                DocumentedType::fromClassName(...),
                $complexTypeNames
            ),
        );
    }
}

<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\ClassReflection;
use ReflectionMethod;

readonly class DocumentedService
{
    public function __construct(
        public string $name,
        public ?string $shortDescription,
        public ?string $longDescription,
        /** @var DocumentedMethod[] */
        public array $methods,
        /** @var DocumentedType[] */
        public array $types,
    ) {
    }

    /**
     * @param ClassReflection<object> $class
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

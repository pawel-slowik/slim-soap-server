<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\ClassReflection;
use Laminas\Code\Reflection\PropertyReflection;
use ReflectionProperty;

class DocumentedType
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        /** @var DocumentedProperty[] */
        public readonly array $properties,
    ) {
    }

    public static function fromClassName(string $className): self
    {
        $reflection = new ClassReflection($className);

        return new self(
            $reflection->getName(),
            self::getTypeDescription($reflection),
            array_map(
                fn (PropertyReflection $property): DocumentedProperty => DocumentedProperty::fromPropertyReflection($property),
                $reflection->getProperties(ReflectionProperty::IS_PUBLIC),
            ),
        );
    }

    private static function getTypeDescription(ClassReflection $reflection): ?string
    {
        $descriptions = [];
        $docBlock = $reflection->getDocBlock();
        if ($docBlock) {
            $descriptions[] = $docBlock->getLongDescription();
            $descriptions[] = $docBlock->getShortDescription();
        }
        $descriptions[] = $reflection->getDocComment();
        $descriptions = array_values(array_filter(array_map(trim(...), $descriptions)));
        return (!empty($descriptions)) ? $descriptions[0] : null;
    }
}

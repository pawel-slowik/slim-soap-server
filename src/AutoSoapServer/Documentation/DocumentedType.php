<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\ClassReflection;
use Laminas\Code\Reflection\PropertyReflection;

class DocumentedType
{
    public readonly string $name;

    public readonly ?string $description;

    /** @var DocumentedProperty[] */
    public readonly array $properties;

    public function __construct(string $className)
    {
        $reflection = new ClassReflection($className);
        $this->name = $reflection->getName();
        $this->description = $this->getTypeDescription($reflection);
        $this->properties = array_map(
            fn (PropertyReflection $property): DocumentedProperty => new DocumentedProperty($property),
            $reflection->getProperties(\ReflectionProperty::IS_PUBLIC),
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
        $descriptions = array_values(array_filter(array_map("trim", $descriptions)));
        return (!empty($descriptions)) ? $descriptions[0] : null;
    }
}

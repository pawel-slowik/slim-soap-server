<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Zend\Code\Reflection\ClassReflection;

class DocumentedType
{
    /** @var string */
    public $name;

    /** @var string|null */
    public $description;

    /** @var DocumentedProperty[] */
    public $properties;

    public function __construct(\ReflectionNamedType $type)
    {
        $reflection = new ClassReflection((string) $type);
        $this->name = $reflection->getName();
        $this->description = $this->getTypeDescription($reflection);
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $this->properties[] = new DocumentedProperty($property);
        }
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

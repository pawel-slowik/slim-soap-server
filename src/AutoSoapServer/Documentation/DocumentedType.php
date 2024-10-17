<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\ClassReflection;
use ReflectionProperty;

readonly class DocumentedType
{
    public function __construct(
        public string $name,
        public ?string $description,
        /** @var DocumentedProperty[] */
        public array $properties,
    ) {
    }

    /**
     * @param class-string $className
     */
    public static function fromClassName(string $className): self
    {
        $reflection = new ClassReflection($className);

        return new self(
            $reflection->getName(),
            self::getTypeDescription($reflection),
            array_map(
                DocumentedProperty::fromPropertyReflection(...),
                $reflection->getProperties(ReflectionProperty::IS_PUBLIC),
            ),
        );
    }

    /**
     * @param ClassReflection<object> $reflection
     */
    private static function getTypeDescription(ClassReflection $reflection): ?string
    {
        $descriptions = [];
        $docBlock = $reflection->getDocBlock();
        if ($docBlock) {
            $descriptions[] = $docBlock->getLongDescription();
            $descriptions[] = $docBlock->getShortDescription();
        }
        $descriptions[] = $reflection->getDocComment();
        $descriptions = array_filter($descriptions);
        $descriptions = array_values(array_filter(array_map(trim(...), $descriptions)));
        return (!empty($descriptions)) ? $descriptions[0] : null;
    }
}

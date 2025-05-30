<?php

declare(strict_types=1);

namespace AutoSoapServer\Documentation;

use Laminas\Code\Reflection\DocBlock\Tag\VarTag;
use Laminas\Code\Reflection\PropertyReflection;

readonly class DocumentedProperty
{
    public function __construct(
        public string $name,
        public ?string $description,
        /** @var string[]|null */
        public ?array $types,
    ) {
    }

    public static function fromPropertyReflection(PropertyReflection $property): self
    {
        return new self(
            $property->getName(),
            self::getDescription($property),
            self::getTypes($property),
        );
    }

    private static function getDescription(PropertyReflection $property): ?string
    {
        $tag = self::getVarTag($property);
        return ($tag) ? $tag->getDescription() : null;
    }

    /**
     * @return string[]|null
     */
    private static function getTypes(PropertyReflection $property): ?array
    {
        $tag = self::getVarTag($property);
        return ($tag) ? $tag->getTypes() : null;
    }

    private static function getVarTag(PropertyReflection $property): ?VarTag
    {
        $docBlock = $property->getDocBlock();
        if ($docBlock) {
            foreach ($docBlock->getTags() as $tag) {
                if ($tag->getName() === "var") {
                    /** @var VarTag $varTag */
                    $varTag = $tag;
                    return $varTag;
                }
            }
        }
        return null;
    }
}

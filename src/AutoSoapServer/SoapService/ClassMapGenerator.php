<?php

declare(strict_types=1);

namespace AutoSoapServer\SoapService;

class ClassMapGenerator
{
    /**
     * @param MappedComplexType[] $mappedComplexTypes
     *
     * @return array<string, class-string>
     */
    public function generate(array $mappedComplexTypes): array
    {
        $map = [];

        foreach ($mappedComplexTypes as $mappedComplexType) {
            $key = $this->stripNamespace($mappedComplexType->xsdType);
            $value = $mappedComplexType->type;
            $map[$key] = $value;
        }

        return $map;
    }

    private static function stripNamespace(string $type): string
    {
        return explode(":", $type, 2)[1];
    }
}

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
        $spiedTypeMap = [];

        foreach ($mappedComplexTypes as $mappedComplexType) {
            $spiedTypeMap[$mappedComplexType->type] = $mappedComplexType->xsdType;
        }

        $typeMap = array_combine(
            array_keys($spiedTypeMap),
            array_map($this->stripNamespace(...), $spiedTypeMap)
        );

        return array_flip($typeMap);
    }

    private static function stripNamespace(string $type): string
    {
        return explode(":", $type, 2)[1];
    }
}

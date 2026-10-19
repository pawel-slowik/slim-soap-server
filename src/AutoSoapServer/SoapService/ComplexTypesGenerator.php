<?php

declare(strict_types=1);

namespace AutoSoapServer\SoapService;

class ComplexTypesGenerator
{
    /**
     * @param MappedComplexType[] $mappedComplexTypes
     *
     * @return class-string[]
     */
    public function generate(array $mappedComplexTypes): array
    {
        $types = [];

        foreach ($mappedComplexTypes as $mappedComplexType) {
            $types[] = $mappedComplexType->type;
        }

        return array_values(array_unique($types));
    }
}

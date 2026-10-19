<?php

declare(strict_types=1);

namespace AutoSoapServer\SoapService;

readonly class MappedComplexType
{
    /**
     * @param class-string $type
     */
    public function __construct(
        public string $type,
        public string $xsdType,
    ) {
    }
}

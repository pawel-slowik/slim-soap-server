<?php

declare(strict_types=1);

namespace AutoSoapServer\SoapService;

class WsdlDocument
{
    public function __construct(
        public readonly string $xml,
        public readonly string $encoding,
    ) {
    }
}

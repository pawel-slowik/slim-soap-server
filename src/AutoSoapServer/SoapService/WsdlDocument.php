<?php

declare(strict_types=1);

namespace AutoSoapServer\SoapService;

readonly class WsdlDocument
{
    public function __construct(
        public string $xml,
        public string $encoding,
    ) {
    }
}

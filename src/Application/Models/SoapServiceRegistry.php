<?php
declare(strict_types=1);

namespace Application\Models;

use Application\RuntimeException;

class SoapServiceRegistry
{

    protected $services = [];

    public function addService(string $path, SoapService $service)
    {
        if ($this->pathIsRegistered($path)) {
            throw new RuntimeException(
                "can't register another SOAP service with the same path: $path"
            );
        }
        $this->services[$path] = $service;
    }

    public function getServiceForPath(string $path): object
    {
        if (!$this->pathIsRegistered($path)) {
            throw new RuntimeException(
                "no SOAP service registered for path: $path"
            );
        }
        return $this->services[$path];
    }

    public function listPaths(): array
    {
        return array_keys($this->services);
    }

    protected function pathIsRegistered(string $path): bool
    {
        return array_key_exists($path, $this->services);
    }
}

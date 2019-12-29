<?php

declare(strict_types=1);

namespace AutoSoapServer\SoapService;

class SoapServiceRegistry
{
    protected $services = [];

    public function addService(string $path, SoapService $service): void
    {
        if ($this->pathIsRegistered($path)) {
            throw new SoapServiceRegistrationFailedException($path);
        }
        $this->services[$path] = $service;
    }

    public function getServiceForPath(string $path): SoapService
    {
        if (!$this->pathIsRegistered($path)) {
            throw new SoapServiceNotFoundException($path);
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

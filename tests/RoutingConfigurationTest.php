<?php

declare(strict_types=1);

namespace Test;

use DI\Container;
use Slim\App;
use Nyholm\Psr7\Factory\Psr17Factory;

use AutoSoapServer\RoutingConfiguration;
use AutoSoapServer\SoapService\SoapServiceRegistry;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AutoSoapServer\RoutingConfiguration
 */
class RoutingConfigurationTest extends TestCase
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var MockObject|SoapServiceRegistry
     */
    private $soapServiceRegistry;

    /**
     * @var RoutingConfiguration
     */
    private $routingConfiguration;

    protected function setUp(): void
    {
        $this->app = new App(new Psr17Factory(), new Container());
        $this->soapServiceRegistry = $this->createMock(SoapServiceRegistry::class);
        $this->routingConfiguration = new RoutingConfiguration($this->soapServiceRegistry);
    }

    public function testApply(): void
    {
        $app = $this->routingConfiguration->apply($this->app);
        $routeCollector = $app->getRouteCollector();
        $this->assertNotEmpty($routeCollector->getRoutes());
    }

    public function testNamedHome(): void
    {
        $app = $this->routingConfiguration->apply($this->app);
        $routeCollector = $app->getRouteCollector();
        try {
            $routeCollector->getNamedRoute("home");
            $exceptionThrown = false;
        } catch (\RuntimeException $ex) {
            $exceptionThrown = true;
        }
        $this->assertFalse($exceptionThrown);
    }

    /**
     * @dataProvider namedFromRegistryDataProvider
     */
    public function testNamedFromRegistry(string $routeName): void
    {
        $this->soapServiceRegistry->method("listPaths")->willReturn(["foo"]);
        $app = $this->routingConfiguration->apply($this->app);
        $routeCollector = $app->getRouteCollector();
        try {
            $routeCollector->getNamedRoute($routeName);
            $exceptionThrown = false;
        } catch (\RuntimeException $ex) {
            $exceptionThrown = true;
        }
        $this->assertFalse($exceptionThrown);
    }

    public function namedFromRegistryDataProvider(): array
    {
        return [
            ["endpoint"],
            ["wsdl"],
            ["doc"],
        ];
    }

    public function testCountFromRegistry(): void
    {
        $this->soapServiceRegistry->method("listPaths")->willReturn(["foo", "bar"]);
        $app = $this->routingConfiguration->apply($this->app);
        $routeCollector = $app->getRouteCollector();
        $this->assertCount(7, $routeCollector->getRoutes());
    }
}

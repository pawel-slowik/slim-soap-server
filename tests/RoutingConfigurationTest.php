<?php

declare(strict_types=1);

namespace Test;

use AutoSoapServer\RoutingConfiguration;
use AutoSoapServer\SoapService\SoapServiceRegistry;
use DI\Container;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Slim\App;

#[CoversClass(RoutingConfiguration::class)]
class RoutingConfigurationTest extends TestCase
{
    /**
     * @var App<Container>
     */
    private App $app;

    private SoapServiceRegistry&MockObject $soapServiceRegistry;

    private RoutingConfiguration $routingConfiguration;

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
        } catch (RuntimeException $ex) {
            $exceptionThrown = true;
        }
        $this->assertFalse($exceptionThrown);
    }

    #[DataProvider("namedFromRegistryDataProvider")]
    public function testNamedFromRegistry(string $routeName): void
    {
        $this->soapServiceRegistry->method("listPaths")->willReturn(["foo"]);
        $app = $this->routingConfiguration->apply($this->app);
        $routeCollector = $app->getRouteCollector();
        try {
            $routeCollector->getNamedRoute($routeName);
            $exceptionThrown = false;
        } catch (RuntimeException $ex) {
            $exceptionThrown = true;
        }
        $this->assertFalse($exceptionThrown);
    }

    /**
     * @return array<array{0: string}>
     */
    public static function namedFromRegistryDataProvider(): array
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

<?php

declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

use AutoSoapServer\RoutingConfiguration;
use DI\Container;
use Nyholm\Psr7\Factory\Psr17Factory;
use Slim\App;

$container = new Container();
$app = new App(new Psr17Factory(), $container);

$dependencies = require __DIR__ . "/../src/dependencies.php";
$dependencies($container, $app);

$middleware = require __DIR__ . "/../src/middleware.php";
$middleware($app);

$routingConfiguration = $container->get(RoutingConfiguration::class);
$app = $routingConfiguration->apply($app);

$app->run();

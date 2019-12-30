<?php

declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

use DI\Container;
use Slim\Factory\AppFactory;

AppFactory::setContainer(new Container());
$app = AppFactory::create();

$dependencies = require __DIR__ . "/../src/dependencies.php";
$dependencies($app);

$middleware = require __DIR__ . "/../src/middleware.php";
$middleware($app);

$routes = require __DIR__ . "/../src/routes.php";
$routes($app);

$app->run();

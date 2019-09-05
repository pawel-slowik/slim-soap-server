<?php
require __DIR__ . "/../vendor/autoload.php";

$app = new \Slim\App;

$dependencies = require __DIR__ . "/../app/dependencies.php";
$dependencies($app);

$routes = require __DIR__ . "/../app/routes.php";
$routes($app);

$app->run();

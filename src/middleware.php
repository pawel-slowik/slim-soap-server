<?php

declare(strict_types=1);

use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return function (App $app): void {
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));

    $app->addErrorMiddleware(false, true, true);
};

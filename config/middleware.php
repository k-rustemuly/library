<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;

return function (App $app) {
    $app->addRoutingMiddleware();
    $app->addBodyParsingMiddleware();
    $app->add(TwigMiddleware::createFromContainer($app));
    $app->add(BasePathMiddleware::class);
    $app->add(ErrorMiddleware::class);
};

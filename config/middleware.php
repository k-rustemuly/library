<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;
use Slim\Views\Twig;


return function (App $app) {
    $app->addRoutingMiddleware();
    $app->addBodyParsingMiddleware();
    $app->add(TwigMiddleware::createFromContainer($app, Twig::class));
    $app->add(BasePathMiddleware::class);
    $app->add(ErrorMiddleware::class);
};

<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;
use Slim\Views\Twig;


return function (App $app) {
    $app->addRoutingMiddleware();
    $app->addBodyParsingMiddleware();
    $app->add(TwigMiddleware::create($app, Twig::create(MAIN_DIR . 'templates',['cache' => MAIN_DIR.'cache'])));
    $app->add(BasePathMiddleware::class);
    $app->add(ErrorMiddleware::class);
};

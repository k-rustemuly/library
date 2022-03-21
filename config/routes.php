<?php
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {

    //Cors
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
                ->withHeader('Access-Control-Allow-Origin', $_ENV['API_IS_DEBUG'] == "true" ? '*':$_ENV['URL'])
                ->withHeader('Access-Control-Allow-Headers', 'X-Auth, Content-Type, Accept, Origin')
                ->withHeader('Access-Control-Expose-Headers', '*')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    $app->get('/', function (Request $request, Response $response){
        $response->getBody()->write('Hello World');
        return $response;
    });

    $app->group(
        '/{lang:(?:kk|ru)}',
        function (RouteCollectorProxy $app) {

            $app->group('/panel', function (RouteCollectorProxy $app) {

                $app->group('/sign-in', function (RouteCollectorProxy $app) {

                    $app->get('', \App\Action\Sign\SignInGetAction::class);

                });

                $app->group('/forgot-password', function (RouteCollectorProxy $app) {

                    $app->get('', \App\Action\Sign\ForgotPasswordGetAction::class)->setName("forgot-password");

                });

                $app->group('/', function (RouteCollectorProxy $app) {

                    $app->get('', \App\Action\Panel\DashboardAction::class)->setName("panel-dashboard");

                });
            });

        });
};
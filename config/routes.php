<?php
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Middleware\PanelMiddleware;

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

                    $app->get('', \App\Action\Sign\SignInGetAction::class)->setName("sign-in");

                    $app->post('', \App\Action\Sign\SignInPostAction::class)->setName("sign-in-post");

                });

                $app->group('/forgot-password', function (RouteCollectorProxy $app) {

                    $app->get('', \App\Action\Sign\ForgotPasswordGetAction::class)->setName("forgot-password");

                });

                $app->group('', function (RouteCollectorProxy $app) {

                    $app->get('/', \App\Action\Panel\DashboardAction::class)->setName("panel-dashboard");

                    $app->group('/book', function (RouteCollectorProxy $app) {

                        $app->get('', \App\Action\Book\ReadAction::class)->setName("panel-book");

                        $app->post('', \App\Action\Book\AddAction::class)->setName("panel-book-add");

                    });

                    $app->group('/author', function (RouteCollectorProxy $app) {

                        $app->get('', \App\Action\Author\ReadAction::class)->setName("panel-author");

                        $app->get('/list', \App\Action\Author\ListAction::class)->setName("panel-author-list");

                        $app->post('', \App\Action\Author\AddAction::class)->setName("panel-author-add");

                    });

                    $app->group('/publisher', function (RouteCollectorProxy $app) {

                        $app->get('', \App\Action\Publisher\ReadAction::class)->setName("panel-publisher");

                        $app->get('/list', \App\Action\Publisher\ListAction::class)->setName("panel-publisher-list");

                        $app->post('', \App\Action\Publisher\AddAction::class)->setName("panel-publisher-add");

                    });

                    $app->group('/series', function (RouteCollectorProxy $app) {

                        $app->get('', \App\Action\Series\ReadAction::class)->setName("panel-series");

                        $app->get('/list', \App\Action\Series\ListAction::class)->setName("panel-series-list");

                        $app->post('', \App\Action\Series\AddAction::class)->setName("panel-series-add");

                    });

                    $app->group('/tag', function (RouteCollectorProxy $app) {

                        $app->get('', \App\Action\Tag\ReadAction::class)->setName("panel-tag");

                        $app->post('', \App\Action\Tag\AddAction::class)->setName("panel-tag-add");

                    });

                    $app->group('/library', function (RouteCollectorProxy $app) {

                        $app->get('', \App\Action\Panel\DashboardAction::class)->setName("panel-library");

                    });

                    $app->group('/language', function (RouteCollectorProxy $app) {

                        $app->get('', \App\Action\Language\ReadAction::class)->setName("panel-language");

                    });

                    $app->group('/selection', function (RouteCollectorProxy $app) {

                        $app->get('', \App\Action\Panel\DashboardAction::class)->setName("panel-selection");

                    });

                })->add(PanelMiddleware::class);

            });

        });
};
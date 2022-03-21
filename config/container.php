<?php
use App\Factory\LoggerFactory;
use App\Handler\DefaultErrorHandler;
use Cake\Database\Connection;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteParserInterface;
use Slim\Middleware\ErrorMiddleware;
use Slim\Psr7\Factory\StreamFactory;
use App\Helper\Language;
use App\Helper\File;
use App\Helper\Authorization;
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;
use Odan\Twig\TwigAssetsExtension;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    Twig::class => function (ContainerInterface $container) {
        $settings = $container->get('settings');
        $twigSettings = $settings['twig'];

        $twig = Twig::create($twigSettings['path'], [
            'cache' => $twigSettings['cache_enabled'] ? $twigSettings['cache_path'] : false,
        ]);

        $loader = $twig->getLoader();
        if ($loader instanceof FilesystemLoader) {
            $loader->addPath($settings['public'], 'public');
        }

        $environment = $twig->getEnvironment();

        // Add Twig extensions
        $twig->addExtension(new TwigAssetsExtension($environment, (array)$settings['assets']));

        return $twig;
    },

    Language::class => function () {
        return new Language();
    },

    Authorization::class => function () {
        return new Authorization();
    },

    File::class => function (ContainerInterface $container) {
        $settings = $container->get('settings');
        return new File($settings["uploads_dir"], $settings["uploads_public_dir"]);
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        return AppFactory::create();
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    StreamFactoryInterface::class => function () {
        return new StreamFactory();
    },

    RouteParserInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getRouteCollector()->getRouteParser();
    },

    LoggerFactory::class => function (ContainerInterface $container) {
        return new LoggerFactory($container->get('settings')['logger']);
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);

        return new BasePathMiddleware($app);
    },

    Connection::class => function (ContainerInterface $container) {
        return new Connection($container->get('settings')['db']);
    },

    PDO::class => function (ContainerInterface $container) {
        $db = $container->get(Connection::class);
        $driver = $db->getDriver();
        $driver->connect();

        return $driver->getConnection();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['error'];
        $app = $container->get(App::class);

        $logger = $container->get(LoggerFactory::class)
            ->addFileHandler('error.log')
            ->createLogger();

        $errorMiddleware = new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details'],
            $logger
        );

        $errorMiddleware->setDefaultErrorHandler($container->get(DefaultErrorHandler::class));

        return $errorMiddleware;
    }

];

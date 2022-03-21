<?php

namespace App\Action\Sign;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\Sign\Service\SignIn;
use Slim\Views\Twig;
/**
 * Action.
 */
final class SignInGetAction {
    /**
     * @var SignIn
     */
    private $service;

    /**
     * @var Twig
     */
    private $twig;

    /**
     * The constructor.
     *
     * @param SignIn $service The service
     * @param Twig $twig The twig engine
     */
    public function __construct(SignIn $service, Twig $twig) {
        $this->service = $service;
        $this->twig = $twig;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array<mixed> $args The arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface{
        return $this->twig->render($response, 'sign-in.html', $this->service->get($args['lang']));
    }
}

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
     * The constructor.
     *
     * @param SignIn $service The service
     */
    public function __construct(SignIn $service) {
        $this->service = $service;
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
        $view = Twig::fromRequest($request);
        return $view->render($response, 'sign-in.html', $this->service->get($args['lang']));
    }
}

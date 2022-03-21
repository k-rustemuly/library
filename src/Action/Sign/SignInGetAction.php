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
        $post = (array)$request->getParsedBody();
        $params = $request->getServerParams();
        $post["lang"] = $args['lang'];
        $post["user_agent"] = $params['HTTP_USER_AGENT'];
        $post["user_ip_address"] = $params['REMOTE_ADDR'];
        $data = $this->service->pkcs($post);
        return $view->render($response, 'sign-in.html', [
            'name' => $args['lang']
        ]);
        return $this->responder->withJson($response, $data);
    }
}

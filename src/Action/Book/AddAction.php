<?php

namespace App\Action\Book;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\Book\Service\Add as Service;
use App\Responder\Responder;
/**
 * Action.
 */
final class AddAction {
    /**
     * @var Service
     */
    private $service;

    /**
     * @var Responder
     */
    private $responder;

    /**
     * The constructor.
     *
     * @param Service $service The service
     * @param Twig $twig The twig engine
     */
    public function __construct(Service $service, Responder $responder) {
        $this->service = $service;
        $this->responder = $responder;
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
        $data = (array)$request->getParsedBody();
        $lang = $args['lang'];
        $this->service->add($data);
        return $this->responder->withRedirectFor($response, 'panel-book', ["lang" => $lang]);
    }
}

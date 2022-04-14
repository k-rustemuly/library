<?php

namespace App\Action\Book;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\Book\Service\Search as Service;
use App\Responder\Responder;
/**
 * Action.
 */
final class SearchAction {
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
        $data = (array)$request->getQueryParams();
        $lang = $args['lang'];
        return $this->responder->success($response, null, $this->service->search($lang, $data));
    }
}

<?php

namespace App\Action\Series;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\Series\Service\Read as Service;
use App\Responder\Responder;
/**
 * Action.
 */
final class ListAction {

    /**
     * @var Service
     */
    private $service;

    /**
     * @var responder
     */
    private $responder;

    /**
     * The constructor.
     *
     * @param Service $service The service
     * @param Responder $responder The responder
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
        return $this->responder->success($response, null, $this->service->list($args['lang']));
    }
}
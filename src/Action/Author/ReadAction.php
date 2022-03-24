<?php

namespace App\Action\Author;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\Author\Service\Get as Service;
use Slim\Views\Twig;
/**
 * Action.
 */
final class ReadAction {
    /**
     * @var Service
     */
    private $service;

    /**
     * @var Twig
     */
    private $twig;

    /**
     * The constructor.
     *
     * @param Service $service The service
     * @param Twig $twig The twig engine
     */
    public function __construct(Service $service, Twig $twig) {
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
        return $this->twig->render($response, 'panel/authors.twig', $this->service->get($args['lang']));
    }
}

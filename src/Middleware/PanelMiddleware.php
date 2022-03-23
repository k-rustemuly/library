<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use SlimSession\Helper as Session;

class PanelMiddleware
{
	/**
	 * JWT Auth existence
	 *
	 * @param  ServerRequestInterface  $request PSR-7 request
	 * @param  RequestHandlerInterface $handler PSR-15 request handler
	 *
	 * @return Response
	 */
	public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): Response{
		$session = new Session();
		$response = $handler->handle($request);
		if($session->exists("admin")) return $response;
		return $response->withHeader('Location', '/ru/panel/sign-in')->withStatus(302);
	}
}
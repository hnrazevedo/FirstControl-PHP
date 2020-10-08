<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NoAuthenticate implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if(isset($_SESSION['user'])){
            throw new \Exception('Não permitido', 403);
        }

        return $handler->handle($request);
    }
}
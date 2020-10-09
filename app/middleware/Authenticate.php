<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Authenticate implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if(!isset($_SESSION['user'])){
            throw new \Exception('<a href="'.SYSTEM['uri'].'/">Necessário login</a>', 401);
        }

        return $handler->handle($request->withAttribute('user',unserialize($_SESSION['user'])));
    }
}

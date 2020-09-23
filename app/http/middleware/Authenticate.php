<?php

namespace App\Http\Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Authenticate implements RequestHandlerInterface{
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new ResponseInterface();
    }

}
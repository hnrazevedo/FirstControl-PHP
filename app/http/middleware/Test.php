<?php

namespace App\Http\Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Test implements RequestHandlerInterface{
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        echo '1';
        die();
        return new ResponseInterface();
    }

}
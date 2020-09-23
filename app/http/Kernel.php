<?php

namespace App\Http;

class Kernel{
    protected $middleware = [
        'test' => \App\Http\Middleware\Test::class
    ];
    
    protected array $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class
    ];
}
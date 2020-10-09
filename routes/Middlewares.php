<?php

use HnrAzevedo\Router\Router;

Router::globalMiddlewares([
    'Authenticate' => App\Middleware\Authenticate::class,
    'NoAuthenticate' => App\Middleware\NoAuthenticate::class,
    'Authorization' => App\Middleware\Authorization::class
]);

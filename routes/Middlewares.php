<?php

use HnrAzevedo\Router\Router;

Router::globalMiddlewares([
    'Auth' => App\Middleware\Authenticate::class,
    'Admin' => App\Middleware\Administrator::class
]);
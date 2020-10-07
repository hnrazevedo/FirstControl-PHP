<?php

use HnrAzevedo\Router\Router;

Router::get('/','App\\Controller\\User@viewLogin');


Router::get('/sair','App\\Controller\\User@logout');



Router::get('/dashboard','App\\Controller\\User@dashboard')
      ->middleware(['Auth'])
      ->name('dashboard');

Router::ajax('/controller/user','App\\Controller\\User@executeData');
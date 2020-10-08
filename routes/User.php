<?php

use HnrAzevedo\Router\Router;

Router::get('/sair','App\\Controller\\User@logout')
      ->middleware(['Auth']);

Router::get('/esqueci-a-senha','App\\Controller\\User@viewRecover')
      ->middleware(['NoAuth']);

Router::get('/usuarios/minha-conta','App\\Controller\\User@viewRegister')
      ->middleware(['Auth']);

Router::ajax('/controller/user','App\\Controller\\User@executeData');

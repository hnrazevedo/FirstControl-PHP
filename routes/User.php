<?php

use HnrAzevedo\Router\Router;

Router::get('/usuario','App\\Controller\\User@viewMenu')
      ->name('userMenu')
      ->middleware(['Authenticate']);

Router::get('/usuario/listagem','App\\Controller\\User@viewList')
      ->name('userList')
      ->middleware(['Authenticate']);

Router::get('/usuario/inscrever','App\\Controller\\User@viewRegister')
      ->name('userRegister')
      ->middleware(['Authenticate']);

Router::get('/usuario/{id}','App\\Controller\\User@viewDetails')
      ->name('userDetails')
      ->middleware(['Authenticate'])
      ->where(['id' => '[0-9]{1,11}']);

Router::ajax('/usuario/listagem','App\\Controller\\User@jsonList')
      ->name('userResultList')
      ->middleware(['Authenticate']);

Router::get('/sair','App\\Controller\\User@logout')
      ->middleware(['Authenticate']);

Router::get('/esqueci-a-senha','App\\Controller\\User@viewRecover')
      ->middleware(['NoAuthenticate']);

Router::get('/usuarios/minha-conta','App\\Controller\\User@viewRegister')
      ->middleware(['Authenticate']);

Router::ajax('/controller/user','App\\Controller\\User@executeData')
      ->middleware(['Authenticate','Authorization']);

Router::get('/usuarios/{id}/permissoes','App\\Controller\\Authorization@details')
      ->middleware(['Authenticate','Authorization'])
      ->name('authorizationDetails')
      ->where(['id' => '[0-9]{1,11}']);

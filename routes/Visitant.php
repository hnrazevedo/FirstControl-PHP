<?php

use HnrAzevedo\Router\Router;

Router::get('/visitante','App\\Controller\\Visitant@viewMenu')
      ->name('visitantMenu')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visitante/listagem','App\\Controller\\Visitant@viewList')
      ->name('visitantList')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visitante/inscrever','App\\Controller\\Visitant@viewRegister')
      ->name('visitantRegister')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visitante/{id}','App\\Controller\\Visitant@viewDetails')
      ->name('visitantDetails')
      ->middleware(['Authenticate','Authorization'])
      ->where(['id' => '[0-9]{1,11}']);

Router::ajax('/visitante/listagem','App\\Controller\\Visitant@jsonList')
      ->name('visitantResultList')
      ->middleware(['Authenticate','Authorization']);

Router::ajax('/controller/visitant','App\\Controller\\Visitant@executeData')
      ->middleware(['Authenticate','Authorization']);

Router::ajax('/visitant/json/{cpf}','App\\Controller\\Visitant@toJson')
      ->where(['cpf' => '[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}'])
      ->middleware(['Authenticate','Authorization']);
      
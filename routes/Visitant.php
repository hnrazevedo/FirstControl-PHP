<?php

use HnrAzevedo\Router\Router;

Router::get('/visitante','App\\Controller\\Visitant@viewMenu')
      ->name('visitantViewMenu')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visitante/listagem','App\\Controller\\Visitant@viewList')
      ->name('visitantViewList')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visitante/inscrever','App\\Controller\\Visitant@viewRegister')
      ->name('visitantViewRegister')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visitante/{id}','App\\Controller\\Visitant@viewDetails')
      ->name('visitantViewDetails')
      ->middleware(['Authenticate','Authorization'])
      ->where(['id' => '[0-9]{1,11}']);

Router::ajax('/visitante/listagem','App\\Controller\\Visitant@jsonList')
      ->name('visitantResultList')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visitante/{id}/edicao','App\\Controller\\Visitant@viewEdition')
      ->middleware(['Authenticate','Authorization'])
      ->name('visitantViewEdition')
      ->where(['id' => '[0-9]{1,11}']);

Router::ajax('/controller/visitant','App\\Controller\\Visitant@executeData')
      ->middleware(['Authenticate','Authorization']);

Router::ajax('/visitant/json/{cpf}','App\\Controller\\Visitant@toJson')
      ->where(['cpf' => '[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}'])
      ->name('visitantJson')
      ->middleware(['Authenticate','Authorization']);
      
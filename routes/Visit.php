<?php

use HnrAzevedo\Router\Router;

Router::get('/visita','App\\Controller\\Visit@viewMenu')
      ->name('visitViewMenu')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visita/listagem','App\\Controller\\Visit@viewList')
      ->name('visitViewList')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visita/inscrever','App\\Controller\\Visit@viewRegister')
      ->name('visitViewRegister')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visita/{id}/finalizar','App\\Controller\\Visit@viewFinish')
      ->name('visitViewFinish')
      ->middleware(['Authenticate','Authorization'])
      ->where(['id' => '[0-9]{1,11}']);

      
Router::get('/visita/{id}/detalhes','App\\Controller\\Visit@viewDetails')
      ->name('visitViewDetails')
      ->middleware(['Authenticate','Authorization'])
      ->where(['id' => '[0-9]{1,11}']);

Router::ajax('/visita/listagem','App\\Controller\\Visit@jsonList')
      ->name('visitResultList')
      ->middleware(['Authenticate','Authorization']);

Router::ajax('/controller/visit','App\\Controller\\Visit@executeData')
      ->middleware(['Authenticate','Authorization']);
      
<?php

use HnrAzevedo\Router\Router;

Router::get('/visita','App\\Controller\\Visit@viewMenu')
      ->name('visitMenu')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visita/listagem','App\\Controller\\Visit@viewList')
      ->name('visitList')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visita/inscrever','App\\Controller\\Visit@viewRegister')
      ->name('visitRegister')
      ->middleware(['Authenticate','Authorization']);

Router::get('/visita/{id}','App\\Controller\\Visit@viewDetails')
      ->name('visitDetails')
      ->middleware(['Authenticate','Authorization'])
      ->where(['id' => '[0-9]{1,11}']);

Router::ajax('/visita/listagem','App\\Controller\\Visit@jsonList')
      ->name('visitResultList')
      ->middleware(['Authenticate','Authorization']);

Router::ajax('/controller/visit','App\\Controller\\Visit@executeData')
      ->middleware(['Authenticate','Authorization']);
      
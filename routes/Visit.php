<?php

use HnrAzevedo\Router\Router;

Router::get('/visita','App\\Controller\\Visit@viewMenu')
      ->name('visitMenu')
      ->middleware(['Authenticate']);

Router::get('/visita/listagem','App\\Controller\\Visit@viewList')
      ->name('visitList')
      ->middleware(['Authenticate']);

Router::get('/visita/inscrever','App\\Controller\\Visit@viewRegister')
      ->name('visitRegister')
      ->middleware(['Authenticate']);

Router::get('/visita/{id}','App\\Controller\\Visit@viewDetails')
      ->name('visitDetails')
      ->middleware(['Authenticate'])
      ->where(['id' => '[0-9]{1,11}']);

Router::ajax('/visita/listagem','App\\Controller\\Visit@jsonList')
      ->name('visitResultList')
      ->middleware(['Authenticate']);

Router::ajax('/controller/visit','App\\Controller\\Visit@executeData')
      ->middleware(['Authenticate']);
      
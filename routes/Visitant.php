<?php

use HnrAzevedo\Router\Router;

Router::get('/visitants','App\\Controller\\Visitant@viewVisitants')
      ->middleware(['Auth'])
      ->name('visitant');

Router::get('/visitant/details/{id}','App\\Controller\\Visitant@viewDetails')
      ->where(['id' => '[0-9]{1,11}'])
      ->middleware(['Auth']);

Router::ajax('/visitants/list','App\\Controller\\Visitant@listVisitants')
      ->middleware(['Auth']);

Router::ajax('/controller/visitant','App\\Controller\\Visitant@executeData')
      ->middleware(['Auth']);

Router::ajax('/visitant/json/{cpf}','App\\Controller\\Visitant@toJson')
      ->where(['cpf' => '[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}'])
      ->middleware(['Auth']);
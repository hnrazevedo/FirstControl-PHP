<?php

use HnrAzevedo\Router\Router;

Router::get('/visit','App\\Controller\\Visit@viewPage')
      ->middleware(['Auth'])
      ->name('visit');

Router::get('/visit/details/{id}','App\\Controller\\Visit@viewDetails')
      ->where(['id' => '[0-9]{1,11}'])
      ->middleware(['Auth']);

Router::ajax('/visit/list','App\\Controller\\Visit@listVisits')
      ->middleware(['Auth']);

Router::ajax('/controller/visit','App\\Controller\\Visit@executeData')
      ->middleware(['Auth']);
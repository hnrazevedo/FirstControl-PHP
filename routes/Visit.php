<?php

use HnrAzevedo\Router\Router;

Router::get('/visit','App\\Controller\\Visit:viewPage')
      ->middleware('auth')
      ->name('visit');

Router::get('/visit/details/{id}','App\\Controller\\Visit:viewDetails')
      ->where('id','[0-9]{1,11}')
      ->middleware('auth');

Router::ajax('/visit/list','App\\Controller\\Visit:listVisits')
      ->middleware('auth');

Router::ajax('/controller/visit','App\\Controller\\Visit:method')
      ->middleware('auth');
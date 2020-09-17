<?php

use HnrAzevedo\Router\Router;

Router::get('/visit','App\\Controller\\Visit:viewPage')
      ->middleware('App\\Filter\\User:user_in')
      ->name('visit');

Router::get('/visit/details/{id}','App\\Controller\\Visit:viewDetails')
      ->where('id','[0-9]{1,11}')
      ->middleware('App\\Filter\\User:user_in');

Router::ajax('/visit/list','App\\Controller\\Visit:listVisits')
      ->middleware('App\\Filter\\User:user_in');

Router::ajax('/controller/visit','App\\Controller\\Visit:method')
      ->middleware('App\\Filter\\User:user_in');
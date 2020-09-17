<?php

use HnrAzevedo\Router\Router;

Router::get('/visitants','App\\Controller\\Visitant:viewVisitants')
      ->middleware('App\\Filter\\User:user_in')
      ->name('visitant');

Router::get('/visitant/details/{id}','App\\Controller\\Visitant:viewDetails')
      ->where('id','[0-9]{1,11}')
      ->middleware('App\\Filter\\User:user_in');

Router::ajax('/visitants/list','App\\Controller\\Visitant:listVisitants')
      ->middleware('App\\Filter\\User:user_in');

Router::ajax('/controller/visitant','App\\Controller\\Visitant:method')
      ->middleware('App\\Filter\\User:user_in');

Router::ajax('/visitant/json/{cpf}','App\\Controller\\Visitant:toJson')
      ->where('cpf','[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}')
      ->middleware('App\\Filter\\User:user_in');
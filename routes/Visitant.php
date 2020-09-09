<?php

use HnrAzevedo\Router\Router;

Router::get('/visitants','App\\Controller\\Visitant:viewVisitants')
      ->filter('App\\Filter\\User:user_in');

Router::get('/visitant/details/{id}','App\\Controller\\Visitant:viewDetails')
      ->where('id','[0-9]{1,11}')
      ->filter('App\\Filter\\User:user_in');

Router::ajax('/visitants/list','App\\Controller\\Visitant:listVisitants')
      ->filter('App\\Filter\\User:user_in');

Router::ajax('/controller/visitant','App\\Controller\\Visitant:method')
      ->filter('App\\Filter\\User:user_in');
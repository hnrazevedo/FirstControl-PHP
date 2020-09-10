<?php

use HnrAzevedo\Router\Router;

Router::get('/visit','App\\Controller\\Visit:viewPage')
      ->filter('App\\Filter\\User:user_in');

Router::get('/visit/details/{id}','App\\Controller\\Visit:viewDetails')
      ->where('id','[0-9]{1,11}')
      ->filter('App\\Filter\\User:user_in');

Router::ajax('/visit/list','App\\Controller\\Visit:listVisits')
      ->filter('App\\Filter\\User:user_in');

Router::ajax('/controller/visit','App\\Controller\\Visit:method')
      ->filter('App\\Filter\\User:user_in');
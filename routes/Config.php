<?php

use HnrAzevedo\Router\Router;

Router::get('/config','App\\Controller\\Config:viewPage')
      ->middleware('App\\Filter\\User:user_in')
      ->name('config');

Router::ajax('/config/list','App\\Controller\\Cisit:listConfig')
      ->middleware('App\\Filter\\User:user_in');

Router::ajax('/controller/config','App\\Controller\\Config:method')
      ->middleware('App\\Filter\\User:user_in');
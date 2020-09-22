<?php

use HnrAzevedo\Router\Router;

Router::get('/config','App\\Controller\\Config:viewPage')
      ->middleware('App\\Filter\\User:user_in')
      ->name('config');

Router::ajax('/config/list','App\\Controller\\Cisit:listConfig')
      ->middleware('App\\Filter\\User:user_in');

Router::ajax('/config/update/{id}/{value}','App\\Controller\\Config:update')
      ->where('id','[0-9]{1,11}')
      ->where('value','[a-zA-Z0-9]{1,100}')
      ->middleware('App\\Filter\\User:user_in');
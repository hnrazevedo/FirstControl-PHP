<?php

use HnrAzevedo\Router\Router;

Router::get('/car','App\\Controller\\Car:viewPage')
      ->middleware('App\\Filter\\User:user_in')
      ->name('car');

Router::get('/car/details/{id}','App\\Controller\\Car:viewDetails')
      ->where('id','[0-9]{1,11}')
      ->middleware('App\\Filter\\User:user_in');

Router::ajax('/car/list','App\\Controller\\Car:listCars')
      ->middleware('App\\Filter\\User:user_in');

Router::ajax('/controller/car','App\\Controller\\Car:method')
      ->middleware('App\\Filter\\User:user_in');

      
Router::ajax('/car/json/{board}','App\\Controller\\Car:toJson')
      ->middleware('App\\Filter\\User:user_in');
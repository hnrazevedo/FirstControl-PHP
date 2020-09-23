<?php

use HnrAzevedo\Router\Router;

Router::get('/car','App\\Controller\\Car:viewPage')
      ->middleware('auth')
      ->name('car');

Router::get('/car/details/{id}','App\\Controller\\Car:viewDetails')
      ->where('id','[0-9]{1,11}')
      ->middleware('auth');

Router::ajax('/car/list','App\\Controller\\Car:listCars')
      ->middleware('auth');

Router::ajax('/controller/car','App\\Controller\\Car:method')
      ->middleware('auth');

      
Router::ajax('/car/json/{board}','App\\Controller\\Car:toJson')
      ->middleware('auth');
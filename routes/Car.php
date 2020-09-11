<?php

use HnrAzevedo\Router\Router;

Router::get('/car','App\\Controller\\Car:viewPage')
      ->filter('App\\Filter\\User:user_in');

Router::get('/car/details/{id}','App\\Controller\\Car:viewDetails')
      ->where('id','[0-9]{1,11}')
      ->filter('App\\Filter\\User:user_in');

Router::ajax('/car/list','App\\Controller\\Car:listCars')
      ->filter('App\\Filter\\User:user_in');

Router::ajax('/controller/car','App\\Controller\\Car:method')
      ->filter('App\\Filter\\User:user_in');

      
Router::ajax('/car/json/{board}','App\\Controller\\Car:toJson')
      ->filter('App\\Filter\\User:user_in');
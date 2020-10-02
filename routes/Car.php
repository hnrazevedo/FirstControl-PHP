<?php

use HnrAzevedo\Router\Router;

Router::get('/car','App\\Controller\\Car@viewPage')
      ->middleware(['Auth'])
      ->name('car');

Router::get('/car/details/{id}','App\\Controller\\Car@viewDetails')
      ->where(['id' => '[0-9]{1,11}'])
      ->middleware(['Auth']);

Router::ajax('/car/list','App\\Controller\\Car@listCars')
      ->middleware(['Auth']);

Router::ajax('/controller/car','App\\Controller\\Car@method')
      ->middleware(['Auth']);

      
Router::ajax('/car/json/{board}','App\\Controller\\Car@toJson')
      ->middleware(['Auth']);
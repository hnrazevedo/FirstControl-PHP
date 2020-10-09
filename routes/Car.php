<?php

use HnrAzevedo\Router\Router;

Router::get('/veiculo','App\\Controller\\Car@viewMenu')
      ->name('carMenu')
      ->middleware(['Authenticate']);

Router::get('/veiculo/listagem','App\\Controller\\Car@viewList')
      ->name('carList')
      ->middleware(['Authenticate']);

Router::get('/veiculo/inscrever','App\\Controller\\Car@viewRegister')
      ->name('carRegister')
      ->middleware(['Authenticate']);

Router::get('/veiculo/{id}','App\\Controller\\Car@viewDetails')
      ->name('carDetails')
      ->middleware(['Authenticate'])
      ->where(['id' => '[0-9]{1,11}']);

Router::ajax('/veiculo/listagem','App\\Controller\\Car@jsonList')
      ->name('carResultList')
      ->middleware(['Authenticate']);

Router::ajax('/controller/car','App\\Controller\\Car@executeData')
      ->middleware(['Authenticate']);
      
Router::ajax('/car/json/{board}','App\\Controller\\Car@toJson')
      ->middleware(['Authenticate']);
      
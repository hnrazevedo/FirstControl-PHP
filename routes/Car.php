<?php

use HnrAzevedo\Router\Router;

Router::get('/veiculo','App\\Controller\\Car@viewMenu')
      ->name('carMenu')
      ->middleware(['Authenticate','Authorization']);

Router::get('/veiculo/listagem','App\\Controller\\Car@viewList')
      ->name('carList')
      ->middleware(['Authenticate','Authorization']);

Router::get('/veiculo/inscrever','App\\Controller\\Car@viewRegister')
      ->name('carRegister')
      ->middleware(['Authenticate','Authorization']);

Router::get('/veiculo/{id}','App\\Controller\\Car@viewDetails')
      ->name('carDetails')
      ->middleware(['Authenticate','Authorization'])
      ->where(['id' => '[0-9]{1,11}']);

Router::ajax('/veiculo/listagem','App\\Controller\\Car@jsonList')
      ->name('carResultList')
      ->middleware(['Authenticate','Authorization']);

Router::ajax('/controller/car','App\\Controller\\Car@executeData')
      ->middleware(['Authenticate','Authorization']);
      
Router::ajax('/car/json/{board}','App\\Controller\\Car@toJson')
      ->middleware(['Authenticate']);
      
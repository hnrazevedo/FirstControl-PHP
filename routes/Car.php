<?php

use HnrAzevedo\Router\Router;

Router::get('/veiculo','App\\Controller\\Car@viewMenu')
      ->name('carViewMenu')
      ->middleware(['Authenticate','Authorization']);

Router::get('/veiculo/listagem','App\\Controller\\Car@viewList')
      ->name('carViewList')
      ->middleware(['Authenticate','Authorization']);

Router::get('/veiculo/inscrever','App\\Controller\\Car@viewRegister')
      ->name('carViewRegister')
      ->middleware(['Authenticate','Authorization']);

Router::get('/veiculo/{id}','App\\Controller\\Car@viewDetails')
      ->name('carViewDetails')
      ->middleware(['Authenticate','Authorization'])
      ->where(['id' => '[0-9]{1,11}']);

Router::ajax('/veiculo/listagem','App\\Controller\\Car@jsonList')
      ->name('carResultList')
      ->middleware(['Authenticate','Authorization']);

Router::get('/veiculo/{id}/edicao','App\\Controller\\car@viewEdition')
      ->middleware(['Authenticate','Authorization'])
      ->name('carViewEdition')
      ->where(['id' => '[0-9]{1,11}']);

Router::ajax('/controller/car','App\\Controller\\Car@executeData')
      ->middleware(['Authenticate','Authorization']);
      
Router::ajax('/car/json/{board}','App\\Controller\\Car@toJson')
      ->name('carJson')
      ->middleware(['Authenticate']);
      
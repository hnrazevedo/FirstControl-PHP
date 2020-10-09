<?php

use HnrAzevedo\Router\Router;

Router::get('/configuracoes','App\\Controller\\Config@viewMenu')
      ->name('configDetails')
      ->middleware(['Authenticate','Authorization']);

Router::ajax('/config/update/{id}/{value}','App\\Controller\\Config@update')
      ->name('configUpdate')
      ->middleware(['Authenticate','Authorization'])
      ->where([
            'id' => '[0-9]{1,11}',
            'value' => '[a-zA-Z0-9]{1,100}'
      ]);
      
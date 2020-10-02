<?php

use HnrAzevedo\Router\Router;

Router::get('/config','App\\Controller\\Config@viewPage')
      ->middleware(['Auth'])
      ->name('config');

Router::ajax('/config/list','App\\Controller\\Config@listConfig')
      ->middleware(['Auth']);

Router::ajax('/config/update/{id}/{value}','App\\Controller\\Config@update')
      ->where([
            'id' => '[0-9]{1,11}',
            'value' => '[a-zA-Z0-9]{1,100}'
      ])->middleware(['Auth']);
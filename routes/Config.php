<?php

use HnrAzevedo\Router\Router;

Router::ajax('/config/update/{id}/{value}','App\\Controller\\Config@update')
      ->where([
            'id' => '[0-9]{1,11}',
            'value' => '[a-zA-Z0-9]{1,100}'
      ])->middleware(['Auth','Admin']);
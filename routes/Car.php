<?php

use HnrAzevedo\Router\Router;

Router::ajax('/controller/car','App\\Controller\\Car@executeData')
      ->middleware(['Auth']);
      
Router::ajax('/car/json/{board}','App\\Controller\\Car@toJson')
      ->middleware(['Auth']);
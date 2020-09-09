<?php

use HnrAzevedo\Router\Router;

Router::get('visits','App\\Controller\\Visit:viewPage')
      ->filter('App\\Filter\\User:user_in');
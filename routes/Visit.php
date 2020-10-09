<?php

use HnrAzevedo\Router\Router;

Router::ajax('/controller/visit','App\\Controller\\Visit@executeData')
      ->middleware(['Auth']);
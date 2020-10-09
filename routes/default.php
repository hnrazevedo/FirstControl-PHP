<?php

use HnrAzevedo\Router\Router;

Router::get('/','App\\Controller\\User@viewLogin');

Router::get('/dashboard','App\\Controller\\User@viewDashboard')
      ->middleware(['Authenticate'])
      ->name('dashboard');

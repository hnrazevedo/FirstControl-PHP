<?php

use HnrAzevedo\Router\Router;

Router::get('/','App\\Controller\\User@view_login');
Router::get('/logout','App\\Controller\\User@logout');
Router::get('/dashboard','App\\Controller\\User@dashboard')
      ->middleware(['Auth'])
      ->name('dashboard');

Router::ajax('/controller/user','App\\Controller\\User@executeData');
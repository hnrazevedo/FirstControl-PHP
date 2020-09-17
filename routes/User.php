<?php

use HnrAzevedo\Router\Router;

Router::get('/','App\\Controller\\User:view_login');
Router::get('/logout','App\\Controller\\User:logout');
Router::get('/dashboard','App\\Controller\\User:dashboard')->middleware('App\\Filter\\User:user_in')->name('dashboard');

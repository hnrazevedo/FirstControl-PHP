<?php

use HnrAzevedo\Router\Router;

Router::ajax('/controller/user','User:method');




Router::get('/','User:view_login');
Router::get('/logout','User:logout');
Router::get('/dashboard','User:dashboard')->filter('User:user_in');

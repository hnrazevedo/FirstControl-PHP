<?php

use HnrAzevedo\Router\Router;

Router::get('/','User:view_login'); 

Router::get('/logout','User:logout');
Router::get('/dashboard','User:dashboard')->filter('User:user_in');

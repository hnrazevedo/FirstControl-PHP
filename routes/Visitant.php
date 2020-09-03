<?php

use HnrAzevedo\Router\Router;

Router::get('visits','Visit:viewPage')->filter('User:user_in');
Router::get('/visitants','Visitant:viewVisitants')->filter('User:user_in');
Router::get('/visitant/details/{id}','Visitant:viewDetails')->where('id','[0-9]{1,11}')->filter('User:user_in');
Router::ajax('/visitants/list','Visitant:listVisitants')->filter('User:user_in');
Router::ajax('/controller/visitant','Visitant:method')->filter('User:user_in');
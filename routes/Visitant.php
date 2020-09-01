<?php

use HnrAzevedo\Router\Router;

Router::get('/visitants','Visitant:view_visitants')->filter('User:user_in');
Router::ajax('/visitants/list','Visitant:list_visitants')->filter('User:user_in');

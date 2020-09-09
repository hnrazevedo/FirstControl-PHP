<?php

use HnrAzevedo\Router\Router;


Router::ajax('/get_menu_list','App\\Controller\\Page:get_list')->filter('App\\Filter\\User:user_in');
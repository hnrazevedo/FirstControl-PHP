<?php

use HnrAzevedo\Router\Router;


Router::ajax('/get_menu_list','Page:get_list')->filter('User:user_in');
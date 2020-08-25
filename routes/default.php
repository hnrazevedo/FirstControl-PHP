<?php

use HnrAzevedo\Router\Router;

Router::get('visits','Visit:view_page')->filter('User:user_in');
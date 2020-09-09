<?php

use HnrAzevedo\Router\Router;

Router::ajax('/validator','App\\Controller\\Validator:work');

Router::ajax('/controller/{entity}','App\\Controller\\{entity}:method');
Router::form('/controller/{entity}','App\\Controller\\{entity}:method');
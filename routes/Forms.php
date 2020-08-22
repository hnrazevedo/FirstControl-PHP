<?php

use HnrAzevedo\Router\Router;

Router::ajax('/validator','Validator:work');

Router::ajax('/controller/{entity}','{entity}:method');
Router::form('/controller/{entity}','{entity}:method');
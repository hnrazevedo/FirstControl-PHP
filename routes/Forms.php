<?php

use HnrAzevedo\Router\Router;

Router::ajax('/validator','App\\Controller\\Validator@work');


//Router::ajax('/controller/{entity}','App\\Controller\\{entity}:method');
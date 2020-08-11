<?php

use HnrAzevedo\Router\Router;
use HnrAzevedo\Viewer\Viewer;

Router::get('/',function(){
    Viewer::create(__DIR__.'/../app/views/')->render('login');
});

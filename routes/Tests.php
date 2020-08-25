<?php

use HnrAzevedo\Router\Router;
use HnrAzevedo\Viewer\Viewer;


Router::get('/test',function(){
    Viewer::create(__DIR__.'/../app/views/test/')
          ->render('index',[
              'value' => '<a href="teste">valores</a>',
              'page' => 'include',
              '_' => 'underline'
          ]);
});
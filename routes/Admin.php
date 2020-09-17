<?php

use HnrAzevedo\Router\Router;



Router::group('/admin',function(){
    
    Router::get('/','App\\Controller\\Admin:view_dashboard');
    Router::get('/users/{?id}','App\\Controller\\Admin:view_users')
          ->where('id','[0-9]{1,11}')
          ->name('users');

    Router::ajax('/result/list/{entity}','App\\Controller\\Admin:result_list');

    Router::ajax('/controller/{entity}','App\\Controller\\Admin:method');

})->middleware(
    ['App\\Filter\\User:user_in','App\\Filter\\Admin:is_admin']//,'Authenticator:authRoute']
);



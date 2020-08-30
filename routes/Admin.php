<?php

use HnrAzevedo\Router\Router;



Router::group('/admin',function(){
    
    Router::get('/','Admin:view_dashboard');
    Router::get('/users/{?id}','Admin:view_users')
          ->where('id','[0-9]{1,11}');

    Router::ajax('/result/list/{entity}','Admin:result_list');

    Router::ajax('/controller/{entity}','Admin:method');

})->filter(
    ['User:user_in','Admin:is_admin']//,'Authenticator:authRoute']
);



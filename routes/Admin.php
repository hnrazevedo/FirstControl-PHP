<?php

use HnrAzevedo\Router\Router;



Router::group('/admin',function(){
    
    Router::get('/','Admin:view_dashboard');
    Router::get('/users','Admin:view_users');

    Router::ajax('/result/list/{entity}','Admin:result_list');

})->filter(
    ['User:user_in','Admin:is_admin']//,'Authenticator:authRoute']
);



<?php

use HnrAzevedo\Router\Router;



Router::group('/admin',function(){
    Router::get('/users','Admin:view_users');
})->filter(
    ['User:user_in','Admin:is_admin','Authenticator:authRoute']
);
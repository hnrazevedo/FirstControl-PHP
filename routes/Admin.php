<?php

use HnrAzevedo\Router\Router;

Router::group('/administracao',function(){

    Router::get('/','App\\Controller\\Admin@viewDashboard');

    Router::get('/registros','App\\Controller\\Admin@viewRegisters');

    Router::ajax('/{entity}/listagem','App\\Controller\\Admin@viewRecords');

    Router::ajax('/controller/{entity}','App\\Controller\\Admin@executeData');

    Router::get('/registros/{entity}','App\\Controller\\Admin@viewRegisterEntity');

    Router::get('/usuarios/registros','App\\Controller\\User@viewList');
    
    Router::get('/usuarios','App\\Controller\\Admin@viewUserMenu');

    Router::get('/novo/{entity}','App\\Controller\\Admin@viewNewEntity');

    Router::get('/usuarios/cadastro','App\\Controller\\User@viewFormRegister');
    
    
    Router::get('/usuarios/{id}','App\\Controller\\User@viewDetails')
          ->where([
                'id' => '[0-9]{1,11}'
            ]);

})->groupMiddlewares(['Auth','Admin']);
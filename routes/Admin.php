<?php

use HnrAzevedo\Router\Router;

Router::group('/administracao',function(){

    Router::get('/','App\\Controller\\Admin@viewDashboard');

    Router::get('/registros','App\\Controller\\Admin@viewRegisters');

    Router::ajax('/controller/{entity}','App\\Controller\\Admin@executeData');

    Router::get('/registros/{entity}','App\\Controller\\Admin@viewRegisterEntity');

    Router::get('/registros/{entity}/listagem','App\\Controller\\Admin@viewRegisterList');

    Router::ajax('/{entity}/listagem','App\\Controller\\Admin@viewRecords');

    Router::get('/novo/{entity}','App\\Controller\\Admin@viewNewEntity');

    Router::get('/{entity}/{id}','App\\Controller\\Admin@viewDetailsEntity')
          ->where([
                'id' => '[0-9]{1,11}'
            ]);

})->groupMiddlewares(['Auth','Admin']);
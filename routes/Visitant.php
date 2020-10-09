<?php

use HnrAzevedo\Router\Router;

Router::ajax('/controller/visitant','App\\Controller\\Visitant@executeData')
      ->middleware(['Auth']);

Router::ajax('/visitant/json/{cpf}','App\\Controller\\Visitant@toJson')
      ->where(['cpf' => '[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}'])
      ->middleware(['Auth']);
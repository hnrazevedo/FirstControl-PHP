<?php

use HnrAzevedo\Router\Router;
use Engine\Config;
use Engine\Util;

try{

    Util::createTemp();

    Config::import(__DIR__.'/../../config/');

    (new Controller\Minify())->mify();

    Router::create()->dispatch();

}catch(Exception $exception){

    echo '<pre>';
    var_dump($exception);

}finally{

    Util::delete(SYSTEM['temp']);

}
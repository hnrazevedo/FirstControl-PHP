<?php

use HnrAzevedo\Router\Router;
use Engine\Util;

try{

    Util::createTemp();

    Router::create()->dispatch();

}catch(Exception $er){

    echo $er->getMessage();

}finally{

    Util::delete(SYSTEM['temp']);

}
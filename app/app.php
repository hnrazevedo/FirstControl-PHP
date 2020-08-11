<?php

use HnrAzevedo\Router\Router;
use Engine\Util;

try{

    $_SESSION['data']['system'] = get_defined_constants()['SYSTEM']; 

    Util::createTemp();

    Router::create()->dispatch();

}catch(Exception $er){

    echo $er->getMessage();

}finally{

    Util::delete(SYSTEM['temp']);

}
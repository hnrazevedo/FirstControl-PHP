<?php

use HnrAzevedo\Router\Router;
use Engine\Util;

try{

    $_SESSION['data']['system'] = get_defined_constants()['SYSTEM']; 

    Util::createTemp();

    Router::create()->dispatch();

}catch(Exception $er){

    if(Util::getProtocol() === 'ajax'){
        
        echo json_encode([
            'error' => [
                'message' => $er->getMessage()
            ]
        ]);

    }else{
        echo 'Error: '.$er->getMessage();
    }

}finally{

    Util::delete(SYSTEM['temp']);

}
<?php

use HnrAzevedo\Router\Router;
use HnrAzevedo\Viewer\Viewer;
use App\Engine\Util;

try{

    $_SESSION['data']['system'] = get_defined_constants()['SYSTEM']; 

    Util::createTemp();

    Router::dispatch();

}catch(Exception $er){
    if(Util::getProtocol() === 'ajax'){
        
        echo json_encode([
            'error' => [
                'message' => $er->getMessage()
            ]
        ]);

    }else{
        Viewer::create(SYSTEM['basepath'].'app/views/global/')
              ->render('error',[
                    'error' => [
                        'code' => $er->getCode(),
                        'message' => $er->getMessage()
                        ]
                ]);
    }

}finally{

    Util::delete(SYSTEM['temp']);

}
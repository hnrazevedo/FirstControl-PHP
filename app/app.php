<?php

use HnrAzevedo\Router\Router;
use HnrAzevedo\Viewer\Viewer;
use App\Engine\Util;

try{

    $_SESSION['data']['system'] = get_defined_constants()['SYSTEM']; 

    Util::createTemp();

    Router::dispatch();

}catch(Exception $er){
    $data = [
        'error' => ['code' => $er->getCode(),'message' => $er->getMessage()]
    ];

    if(Util::getProtocol() === 'ajax'){
        echo json_encode($data);
    }else{
        Viewer::create(SYSTEM['basepath'].'app/views/')->render('error',$data);
    }

}finally{

    Util::delete(SYSTEM['temp']);

}
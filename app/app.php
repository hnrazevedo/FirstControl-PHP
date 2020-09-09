<?php

use HnrAzevedo\Router\Router;
use HnrAzevedo\Viewer\Viewer;
use App\Engine\Util;

try{

    $_SESSION['view']['data']['system'] = get_defined_constants()['SYSTEM']; 

    Util::createTemp();

    $path = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'routes';

    foreach (scandir($path) as $routeFile) {
        if(pathinfo($path.DIRECTORY_SEPARATOR.$routeFile, PATHINFO_EXTENSION) === 'php'){
            require_once($path. DIRECTORY_SEPARATOR .$routeFile);
        }
    }

    Router::dispatch();

}catch(Exception $er){
    $data = [
        'error' => ['code' => $er->getCode(),'message' => $er->getMessage()]
    ];

    if(Util::getProtocol() === 'ajax'){
        echo json_encode($data);
    }else{
        Viewer::create(SYSTEM['basepath'].'app/views/')->render('error',array_merge($data,$_SESSION['view']['data']));
    }

}finally{
    
    unset($_SESSION['view']['data']['system']);

    Util::delete(SYSTEM['temp']);

}
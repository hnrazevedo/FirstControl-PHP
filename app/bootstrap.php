<?php

use HnrAzevedo\Router\Router;
use HnrAzevedo\Viewer\Viewer;
use App\Engine\Util;

try{
    //Import config
    $path = __DIR__.'/../config/';
    foreach (scandir($path) as $configFile) {
        if(pathinfo("{$path}/{$configFile}", PATHINFO_EXTENSION) === 'php'){
            require_once("{$path}/{$configFile}");
        }
    }

    //Import routes
    $path = __DIR__.'/../routes';
    foreach (scandir($path) as $routeFile) {
        if(pathinfo($path.DIRECTORY_SEPARATOR.$routeFile, PATHINFO_EXTENSION) === 'php'){
            require_once($path. DIRECTORY_SEPARATOR .$routeFile);
        }
    }

    $_SESSION['view']['data']['system'] = get_defined_constants()['SYSTEM']; 
    $_SESSION['view']['data']['user'] = (array_key_exists('user',$_SESSION)) ? unserialize($_SESSION['user']) : null;

    Util::createTemp();

    Router::load();

    $_SESSION['view']['data']['router'] = Router::current(); 

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
    
    unset($_SESSION['view']);

    Util::delete(SYSTEM['temp']);

}
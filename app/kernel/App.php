<?php

namespace App\Kernel;

use HnrAzevedo\Router\Router;
use HnrAzevedo\Viewer\Viewer;
use App\Engine\Util;

class App
{
    public function load(): App
    {
        $this->importConfigs()->importRoutes()->loadRouter();
        Util::createTemp();
        return $this;
    }

    public function run(): void
    {
        $_SESSION['view']['data'] = (isset($_SESSION['view']['data'])) ? $_SESSION['view']['data'] : [];
        try{
            $_SESSION['view']['data']['system'] = get_defined_constants()['SYSTEM']; 
            $_SESSION['view']['data']['user'] = (array_key_exists('user',$_SESSION)) ? unserialize($_SESSION['user']) : null;
            Router::run();
        }catch(\Exception $er){
            $this->reportError($er);
        }finally{
            $this->clear();
        }
    }

    private function reportError(\Exception $er): bool
    {
        $data = ['error' => ['code' => $er->getCode(),'message' => $er->getMessage()]];
        
        if(Util::getProtocol() === 'AJAX'){
            echo json_encode($data);
            return true;
        }

        Viewer::path(SYSTEM['basepath'].'app/views/')->render('error', array_merge($data, $_SESSION['view']['data']));
        
        return true;
    }

    private function clear(): void
    {
        unset($_SESSION['view']);
        Util::delete(SYSTEM['temp']);
    }

    private function loadRouter(): App
    {
        Router::load();
        $_SESSION['view']['data']['router'] = Router::current();
        return $this;
    }

    private function importConfigs(): App
    {
        $path = __DIR__.'/../../config/';
        foreach (scandir($path) as $configFile) {
            if(pathinfo("{$path}/{$configFile}", PATHINFO_EXTENSION) === 'php'){
                require_once("{$path}/{$configFile}");
            }
        }
        return $this;
    }

    private function importRoutes(): App
    {
        if(!isset($_SESSION['cache']['routes'])){
            $path = (isset(SYSTEM['router.path'])) ? SYSTEM['router.path'] : __DIR__.'/../routes';
    
            foreach (scandir($path) as $routeFile) {
                if(pathinfo($path . DIRECTORY_SEPARATOR . $routeFile, PATHINFO_EXTENSION) === 'php'){
                    require_once($path . DIRECTORY_SEPARATOR . $routeFile);
                }
            }
    
            $_SESSION['cache']['router']['middlewares'] = Router::globalMiddlewares();
            $_SESSION['cache']['router']['routes'] = Router::routes();
        }
        
        Router::routes($_SESSION['cache']['router']['routes']);
        Router::globalMiddlewares($_SESSION['cache']['router']['middlewares']);
    
        return $this;
    }

}

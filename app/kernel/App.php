<?php

namespace App\Kernel;


use App\Model\Authorization;
use App\Model\Permission;
use HnrAzevedo\Router\Router;
use HnrAzevedo\Viewer\Viewer;
use App\Engine\Util;

class App
{
    public function load(): App
    {
        $this->importConfigs()->importRoutes()->loadRouter()->authorizationInCache();
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

    private function reportError(\Exception $er): void
    {
        $data = ['error' => ['code' => $er->getCode(),'message' => $er->getMessage()]];
        
        if(Util::getProtocol() === 'AJAX'){
            echo json_encode($data);
            return;
        }

        Viewer::path(SYSTEM['basepath'].'app/views/')->render('error', array_merge($data, $_SESSION['view']['data']));
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

    private function authorizationInCache(): App
    {
        if(!isset($_SESSION['user']) || isset($_SESSION['cache']['authorizations'])){
            return $this;
        }

        $_SESSION['cache']['authorizations'] = [
            'routes' => [],
            'forms' => []
        ];

        $auths = (new Authorization())->find()->only('permission')->where([
            ['user', '=', (unserialize($_SESSION['user']))->id]
        ])->execute()->toEntity();

        $permissions = [];
        foreach($auths as $auth){
            $permissions[] = $auth->permission;
        }

        $perm = (new Permission())->find()->where([
            ['id','IN',$permissions]
        ])->execute()->toEntity();

        foreach($perm as $p){
            $_SESSION['cache']['authorizations']['routes'][] = $p->route;
            $_SESSION['cache']['authorizations']['forms'][] = $p->form;
        }
        return $this;
    }

}

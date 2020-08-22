<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use App\Model\Page as Model;
use App\Model\Authenticator as Authenticator;
use Exception;

class Page extends Controller{

    private ?Model $entity;
    private ?Authenticator $auth;

    public function __construct()
    {
        $this->entity = new Model();
        $this->auth = new Authenticator();
    }

    public function get_list()
    {
        $user = unserialize($_SESSION['user']);

        $auth = $this->auth->find()->only('page')->where([
            ['user','=',$user->id]
        ])->execute();

        if($auth->getCount() === 0){
            throw new Exception('The system administrator has not assigned you any permissions.');
        }

        $auth = $auth->toEntity();
        
        $pagesID = [];
        foreach($auth as $au => $value){
            $pagesID[] = $value->page;
        }

        $menu = $this->entity->find()->where([
            ['name','<>','default'],
            ['id','in',$pagesID]
        ])->orderBy('tag','ASC')->execute();

        $json = [];
        foreach($menu->result() as $m => $value){
            $json[] = [
                'url' => $value['path'],
                'name' => $value['name'],
                'submenu' => $value['tag'],
                'id' => $value['id']
            ];
        }

        echo json_encode($json);
    }

}

<?php

namespace Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use Model\User as Model;
use Engine\Util;
use Exception;


class Admin extends Controller{

    private ?Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function view_users()
    {
        $data = [
            'title' => 'Permissões de usuários',
            'page' => '../admin/user/authorization',
            'pageID' => 2
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/admin/')->render('index',$data);
    }

    public function view_dashboard()
    {
        $data = [
            'title' => 'Painel de controle',
            'page' => '../admin/dashboard/dashboard',
            'pageID' => 3
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/admin/')->render('index',$data);
    }

}

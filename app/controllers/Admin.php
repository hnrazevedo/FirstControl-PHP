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
        Viewer::create(SYSTEM['basepath'].'app/views/admin/user/')->render('index');
    }

}

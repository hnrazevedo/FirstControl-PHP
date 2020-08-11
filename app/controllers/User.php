<?php

namespace Controller;

use HnrAzevedo\Viewer\Viewer;
use Model\User as Model;
use Exception;


class User{

    private ?Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function logof()
    {
        unset($_SESSION['user']);
        setcookie('user',null,-1,'/');
        header('Location: /');
    }

}

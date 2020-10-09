<?php

namespace App\Controller;

use App\Model\Permission as Model;

class Permission extends Controller
{
    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }
    
}

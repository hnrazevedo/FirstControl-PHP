<?php

namespace Model;

use HnrAzevedo\Datamanager\Model as Entity;

Class User extends Entity{

    public function __construct(){
        return parent::create('user','id');
    }
}

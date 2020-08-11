<?php

namespace Model;

use HnrAzevedo\Datamanager\Datamanager;

Class User extends Datamanager{

    public function __construct(){
        return parent::create('user','id');
    }
}

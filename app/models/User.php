<?php

namespace Model;

use HnrAzevedo\Datamanager\Model;

Class User extends Model{

    public function __construct(){
        return parent::create('user','id');
    }
}

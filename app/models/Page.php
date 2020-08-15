<?php

namespace Model;

use HnrAzevedo\Datamanager\Model as Entity;

Class Page extends Entity{

    public function __construct(){
        return parent::create('page','id');
    }
}

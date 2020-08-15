<?php

namespace Model;

use HnrAzevedo\Datamanager\Model;

Class Page extends Model{

    public function __construct(){
        return parent::create('page','id');
    }
}

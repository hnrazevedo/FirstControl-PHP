<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

Class Config extends Entity{

    public function __construct(){
        return parent::create('config','id');
    }
}

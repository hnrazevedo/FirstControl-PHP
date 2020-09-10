<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

Class Car extends Entity{

    public function __construct(){
        return parent::create('car','id');
    }

}

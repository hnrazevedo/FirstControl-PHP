<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

Class Visit extends Entity{

    public function __construct(){
        return parent::create('visit','id');
    }

}

<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

Class Visitant extends Entity{

    public function __construct(){
        return parent::create('visitant','id');
    }

}

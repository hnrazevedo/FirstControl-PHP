<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

Class Authenticator extends Entity{

    public function __construct(){
        return parent::create('authorization','');
    }
}

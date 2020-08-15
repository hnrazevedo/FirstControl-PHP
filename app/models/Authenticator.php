<?php

namespace Model;

use HnrAzevedo\Datamanager\Model;

Class Authenticator extends Model{

    public function __construct(){
        return parent::create('authorization');
    }
}

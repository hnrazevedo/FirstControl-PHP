<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

/** 
  * @property int $user
  * @property int $page
  * @property int $form 
  */ 
Class Authenticator extends Entity
{
    public function __construct(){
        return parent::create('authorization','');
    }
}

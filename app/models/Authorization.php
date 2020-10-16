<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

/** 
  * @property int $id 
  * @property int $user 
  * @property int $permission
  */ 
Class Authorization extends Entity
{
    public function __construct()
    {
        parent::create('authorization', 'id');
    }
}

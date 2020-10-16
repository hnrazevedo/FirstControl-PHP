<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

/** 
  * @property int $id 
  * @property string $description 
  * @property string $tag
  * @property string $route 
  * @property string $form
  */ 
Class Permission extends Entity
{
    public function __construct()
    {
        parent::create('permission', 'id');
    }
}

<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

/** 
  * @property int $id 
  * @property string $resume
  * @property string $value
  */ 
Class Config extends Entity
{
    public function __construct()
    {
        parent::create('config', 'id');
    }
}

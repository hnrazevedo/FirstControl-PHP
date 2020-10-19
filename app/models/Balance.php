<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

/** 
  * @property int $id 
  * @property float $input
  * @property float $ending
  */ 
Class Balance extends Entity
{
    public function __construct()
    {
        parent::create('balance', 'id');
    }
}

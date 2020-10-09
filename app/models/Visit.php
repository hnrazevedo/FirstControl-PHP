<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

/** 
  * @property int $id 
  * @property int $visitant 
  * @property string $started
  * @property string $finished
  * @property string $reason
  * @property string $lastvisit
  * @property string $responsible
  * @property int $status
  * @property int $car
  * @property int $user
  */ 
Class Visit extends Entity
{
    public function __construct(){
        return parent::create('visit','id');
    }
}

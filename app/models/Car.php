<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

/** 
  * @property int $id 
  * @property string $board
  * @property string $brand
  * @property string $model
  * @property string $color
  * @property int $axes
  * @property string $driver 
  * @property string $photo
  */ 
Class Car extends Entity{

    public function __construct(){
        return parent::create('car','id');
    }

}

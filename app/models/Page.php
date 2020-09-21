<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

/** 
  * @property int $id 
  * @property string $name 
  * @property string $tag 
  * @property string $path 
  * @property datetime $register
  */ 
Class Page extends Entity{

    public function __construct(){
        return parent::create('page','id');
    }
}

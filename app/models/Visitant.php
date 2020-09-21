<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

/** 
  * @property int $id 
  * @property string $name 
  * @property string $cpf
  * @property string $rg
  * @property date $birth
  * @property datetime $lastvisit
  * @property datetime $register
  * @property string $company
  * @property string $phone
  * @property string $email
  * @property string $phone
  */ 
Class Visitant extends Entity{

    public function __construct(){
        return parent::create('visitant','id');
    }

}

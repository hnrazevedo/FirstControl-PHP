<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

/** 
  * @property int $id 
  * @property string $name 
  * @property string $cpf
  * @property string $rg
  * @property string $birth
  * @property string $lastvisit
  * @property string $register
  * @property string $company
  * @property string $photo
  * @property string $email
  * @property string $phone
  */ 
Class Visitant extends Entity
{
    public function __construct()
    {
        return parent::create('visitant', 'id');
    }
}

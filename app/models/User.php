<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

/** 
  * @property int $id 
  * @property string $name 
  * @property string $username 
  * @property string $email 
  * @property string $password 
  * @property string $code 
  * @property string $birth 
  * @property string $register 
  * @property string $lastaccess
  * @property string $photo
  * @property int $status
  * @property int $type
  */ 
Class User extends Entity
{
    public function __construct()
    {
        $this->fields = [
            'email'=>'Email',
            'username'=>'Nome de usuário'
        ];

        return parent::create('user', 'id');
    }

    public function isAdmin(): bool
    {
        return ($this->type == 1);
    }
}

<?php

namespace App\Model;

use HnrAzevedo\Datamanager\Model as Entity;

Class User extends Entity{

    private array $fields;

    public function __construct(){
        
        $this->fields = [
            'email'=>'Email',
            'username'=>'Nome de usuário'
        ];

        return parent::create('user','id');
    }

}

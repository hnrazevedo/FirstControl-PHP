<?php

namespace App\Rules;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class Admin
{
    public function __construct()
    {
        Validator::add($this,function(Rules $rules){
            $rules->setAction('updateUser')
                  ->addField('edit_id',['minlength'=>1,'maxlength'=>11,'regex'=>'/^[0-9]{1,11}$/','required'=>true])
                  ->addField('edit_status',['minlength'=>1,'maxlength'=>1,'regex'=>'/^[0-1]{1}$/','required'=>true])
                  ->addField('edit_type',['minlength'=>1,'maxlength'=>1,'regex'=>'/^[0-1]{1}$/','required'=>true])
                  ->addField('edit_password',['minlength'=>1,'maxlength'=>20,'required'=>false])
                  ->addField('edit_password2',['equals'=>'edit_password','required'=>false]);
            return $rules;
        });
    }
}

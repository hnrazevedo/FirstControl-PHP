<?php

namespace App\Rules;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class Admin{

    public function __construct()
    {
        Validator::add($this,function(Rules $rules){
            $rules->setAction('status_user')
                  ->addField('dataselect',['mincount'=>1,'required'=>true])
                  ->addField('role',['minlength'=>1,'maxlength'=>20 ,'required'=>true]);
            
            $rules->setAction('edit_user')
                  ->addField('edit_id',['minlength'=>1,'maxlength'=>11,'regex'=>'/^[0-9]{1,11}$/','required'=>true])
                  ->addField('edit_password',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->addField('edit_password2',['equals'=>'edit_password','minlength'=>1,'maxlength'=>20,'required'=>true]);
            return $rules;
        });
    }
}

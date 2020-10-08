<?php

namespace App\Rules;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class User{

    public function __construct()
    {
        Validator::add($this,function(Rules $rules){
            $rules->setAction('login')
                  ->addField('log_username',['minlength'=>1,'maxlength'=>20 ,'required'=>true])
                  ->addField('log_password',['minlength'=>1,'maxlength'=>20,'required'=>true]);

            $rules->setAction('registerUser')
                  ->addField('new_name',['minlength'=>1,'maxlength'=>50,'required'=>true])
                  ->addField('new_username',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->addField('new_email',['minlength'=>1,'maxlength'=>100,'filter'=>FILTER_VALIDATE_EMAIL,'required'=>true])
                  ->addField('new_password',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->addField('new_password2',['equals'=>'new_password','minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->addField('new_birth',['minlength'=>1,'maxlength'=>10,'regex'=>'/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/','required'=>true]);
            return $rules;
        });
    }
}

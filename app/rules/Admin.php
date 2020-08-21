<?php

namespace HnrAzevedo\Validator;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class Admin{

    public function __construct()
    {
        Validator::add($this,function(Rules $rules){
            $rules->setAction('status_user')
                  ->addField('dataselect',['mincount'=>1,'required'=>true])
                  ->addField('role',['minlength'=>1,'maxlength'=>20 ,'required'=>true]);

            return $rules;
        });
    }
}
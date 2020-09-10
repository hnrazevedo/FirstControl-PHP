<?php

namespace App\Rules;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class Car{

    public function __construct()
    {
        Validator::add($this,function(Rules $rules){
            $rules->setAction('statusCar')
                  ->addField('dataselect',['mincount'=>1,'required'=>true])
                  ->addField('role',['minlength'=>1,'maxlength'=>20 ,'required'=>true]);
            
            $rules->setAction('carRegister')
                  ->addField('new_cpf',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/','required'=>true])  
                  ->addField('new_board',['minlength'=>1,'maxlength'=>8,'required'=>true])
                  ->addField('new_brand',['minlength'=>1,'maxlength'=>20,'required'=>true])  
                  ->addField('new_model',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->addField('new_color',['minlength'=>1,'maxlength'=>10,'required'=>true])   
                  ->addField('new_axes',['minlength'=>1,'maxlength'=>1,'regex'=>'/^[0-9]{1}$/','required'=>true]);
            
            return $rules;
        });
    }
}

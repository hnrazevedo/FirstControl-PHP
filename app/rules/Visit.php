<?php

namespace App\Rules;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class Visit
{
    public function __construct()
    {
        Validator::add($this,function(Rules $rules){
            $rules->setAction('statusVisit')
                  ->addField('dataselect',['mincount'=>1,'required'=>true])
                  ->addField('role',['minlength'=>1,'maxlength'=>20 ,'required'=>true]);
            
            $rules->setAction('register')
                  ->addField('new_reason',['minlength'=>1,'maxlength'=>100,'required'=>true])  
                  ->addField('new_responsible',['minlength'=>1,'maxlength'=>50,'required'=>true])      
                  ->addField('new_name',['minlength'=>1,'maxlength'=>50,'required'=>true])
                  ->addField('new_cpf',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/','required'=>true])
                  ->addField('new_rg',['minlength'=>1,'maxlength'=>12,'regex'=>'/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\-[0-9a-zA-Z]{1}$/','required'=>true])
                  ->addField('new_email',['minlength'=>1,'filter'=>FILTER_VALIDATE_EMAIL,'maxlength'=>100,'required'=>false])
                  ->addField('new_birth',['minlength'=>1,'maxlength'=>10,'regex'=>'/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/','required'=>true])
                  ->addField('new_phone',['minlength'=>1,'maxlength'=>15,'regex'=>'/^\([0-9]{2}\)\ [0-9]{5}\-[0-9]{4}$/','required'=>true])                  
                  ->addField('new_company',['minlength'=>1,'maxlength'=>50,'required'=>true])
                  ->addField('new_photo',['required'=>false])
                  ->addField('new_carphoto',['required'=>false])
                  ->addField('new_board',['minlength'=>1,'maxlength'=>8,'required'=>true])
                  ->addField('new_brand',['minlength'=>1,'maxlength'=>20,'required'=>true])  
                  ->addField('new_model',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->addField('new_color',['minlength'=>1,'maxlength'=>10,'required'=>true])   
                  ->addField('new_axes',['minlength'=>1,'maxlength'=>1,'regex'=>'/^[0-9]{1}$/','required'=>true]);
            
            return $rules;
        });
    }
}

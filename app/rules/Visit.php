<?php

namespace App\Rules;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class Visit
{
    public function __construct()
    {
        Validator::add($this,function(Rules $rules){
            $rules->action('finish')
                  ->field('upt_id',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[0-9]{1,11}$/','required'=>true])
                  ->field('upt_weight',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[\d,.?!]{1,11}$/','required'=>true]);
            
            $rules->action('register')
                  ->field('new_reason',['minlength'=>1,'maxlength'=>100,'required'=>true])  
                  ->field('new_responsible',['minlength'=>1,'maxlength'=>50,'required'=>true])      
                  ->field('new_name',['minlength'=>1,'maxlength'=>50,'required'=>true])
                  ->field('new_cpf',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/','required'=>true])
                  ->field('new_rg',['minlength'=>1,'maxlength'=>12,'regex'=>'/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\-[0-9a-zA-Z]{1}$/','required'=>true])
                  ->field('new_email',['minlength'=>1,'filter'=>FILTER_VALIDATE_EMAIL,'maxlength'=>100,'required'=>false])
                  ->field('new_transport',['minlength'=>1,'maxlength'=>50,'required'=>true])
                  ->field('new_phone',['minlength'=>1,'maxlength'=>15,'regex'=>'/^\([0-9]{2}\)\ [0-9]{5}\-[0-9]{4}$/','required'=>true])                  
                  ->field('new_company',['minlength'=>1,'maxlength'=>50,'required'=>true])
                  ->field('new_photo',['required'=>false])
                  ->field('new_carphoto',['required'=>false])
                  ->field('new_board',['minlength'=>1,'maxlength'=>8,'required'=>true])
                  ->field('new_brand',['minlength'=>1,'maxlength'=>20,'required'=>true])  
                  ->field('new_model',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->field('new_color',['minlength'=>1,'maxlength'=>10,'required'=>true])   
                  ->field('new_axes',['minlength'=>1,'maxlength'=>1,'regex'=>'/^[0-9]{1}$/','required'=>true])
                  ->field('new_weight',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[0-9]{1,11}\.[0-9]{2}$/','required'=>true])
                  ->field('new_note',['minlength'=>1,'maxlength'=>200,'required'=>false]);
            
            return $rules;
        });
    }
}

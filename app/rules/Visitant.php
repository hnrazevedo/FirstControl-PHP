<?php

namespace App\Rules;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class Visitant
{
    public function __construct()
    {
        Validator::add($this,function(Rules $rules){
            $rules->action('statusVisitant')
                  ->field('dataselect',['mincount'=>1,'required'=>true])
                  ->field('role',['minlength'=>1,'maxlength'=>20 ,'required'=>true]);
            
            $rules->action('register')
                  ->field('new_photo',['regex'=>'/^data:image\/[^;]+;base64[^"]+$/','required'=>false])
                  ->field('new_name',['minlength'=>1,'maxlength'=>50,'required'=>true])
                  ->field('new_cpf',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/','required'=>true])
                  ->field('new_rg',['minlength'=>1,'maxlength'=>12,'regex'=>'/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\-[0-9a-zA-Z]{1}$/','required'=>true])
                  ->field('new_email',['minlength'=>1,'filter'=>FILTER_VALIDATE_EMAIL,'maxlength'=>100,'required'=>false])
                  ->field('new_transport',['minlength'=>1,'maxlength'=>50,'required'=>false])
                  ->field('new_phone',['minlength'=>1,'maxlength'=>15,'regex'=>'/^\([0-9]{2}\)\ [0-9]{5}\-[0-9]{4}$/','required'=>true])                  
                  ->field('new_company',['minlength'=>1,'maxlength'=>50,'required'=>true]);

            $rules->action('edition')
                  ->field('edit_id',['regex'=>'/^[0-9]{1,11}$/','required'=>true])
                  ->field('edit_photo',['regex'=>'/^data:image\/[^;]+;base64[^"]+$/','required'=>false])
                  ->field('edit_name',['minlength'=>1,'maxlength'=>50,'required'=>true])
                  ->field('edit_cpf',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/','required'=>true])
                  ->field('edit_rg',['minlength'=>1,'maxlength'=>12,'regex'=>'/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\-[0-9a-zA-Z]{1}$/','required'=>true])
                  ->field('edit_email',['minlength'=>1,'filter'=>FILTER_VALIDATE_EMAIL,'maxlength'=>100,'required'=>false])
                  ->field('edit_transport',['minlength'=>1,'maxlength'=>50,'required'=>false])
                  ->field('edit_phone',['minlength'=>1,'maxlength'=>15,'regex'=>'/^\([0-9]{2}\)\ [0-9]{5}\-[0-9]{4}$/','required'=>true])                  
                  ->field('edit_company',['minlength'=>1,'maxlength'=>50,'required'=>true]);
            
            return $rules;
        });
    }
}

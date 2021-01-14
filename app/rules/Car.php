<?php

namespace App\Rules;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class Car
{
    public function __construct()
    {
        Validator::add($this,function(Rules $rules){
            $rules->action('register')
                  ->field('new_carphoto',['regex'=>'/^data:image\/[^;]+;base64[^"]+$/','required'=>false])
                  ->field('new_cpf',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/','required'=>true])  
                  ->field('new_board',['minlength'=>1,'maxlength'=>8,'required'=>true])
                  ->field('new_brand',['minlength'=>1,'maxlength'=>20,'required'=>true])  
                  ->field('new_model',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->field('new_color',['minlength'=>1,'maxlength'=>10,'required'=>true])   
                  ->field('new_axes',['minlength'=>1,'maxlength'=>1,'regex'=>'/^[0-9]{1}$/','required'=>true]);

            $rules->action('edition')
                  ->field('edit_id',['regex'=>'/^[0-9]{1,11}$/','required'=>true])
                  ->field('edit_carphoto',['regex'=>'/^data:image\/[^;]+;base64[^"]+$/','required'=>false])
                  ->field('edit_cpf',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/','required'=>true])  
                  ->field('edit_board',['minlength'=>1,'maxlength'=>8,'required'=>true])
                  ->field('edit_brand',['minlength'=>1,'maxlength'=>20,'required'=>true])  
                  ->field('edit_model',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->field('edit_color',['minlength'=>1,'maxlength'=>10,'required'=>true])   
                  ->field('edit_axes',['minlength'=>1,'maxlength'=>1,'regex'=>'/^[0-9]{1}$/','required'=>true]);
            
            return $rules;
        });
    }
}

<?php

namespace App\Rules;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class Car
{
    public function __construct()
    {
        Validator::add($this,function(Rules $rules){
            $rules->setAction('register')
                  ->addField('new_carphoto',['regex'=>'/^data:image\/[^;]+;base64[^"]+$/','required'=>false])
                  ->addField('new_cpf',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/','required'=>true])  
                  ->addField('new_board',['minlength'=>1,'maxlength'=>8,'required'=>true])
                  ->addField('new_brand',['minlength'=>1,'maxlength'=>20,'required'=>true])  
                  ->addField('new_model',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->addField('new_color',['minlength'=>1,'maxlength'=>10,'required'=>true])   
                  ->addField('new_axes',['minlength'=>1,'maxlength'=>1,'regex'=>'/^[0-9]{1}$/','required'=>true]);

            $rules->setAction('edition')
                  ->addField('edit_id',['regex'=>'/^[0-9]{1,11}$/','required'=>true])
                  ->addField('edit_carphoto',['regex'=>'/^data:image\/[^;]+;base64[^"]+$/','required'=>false])
                  ->addField('edit_cpf',['minlength'=>1,'maxlength'=>14,'regex'=>'/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/','required'=>true])  
                  ->addField('edit_board',['minlength'=>1,'maxlength'=>8,'required'=>true])
                  ->addField('edit_brand',['minlength'=>1,'maxlength'=>20,'required'=>true])  
                  ->addField('edit_model',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->addField('edit_color',['minlength'=>1,'maxlength'=>10,'required'=>true])   
                  ->addField('edit_axes',['minlength'=>1,'maxlength'=>1,'regex'=>'/^[0-9]{1}$/','required'=>true]);
            
            return $rules;
        });
    }
}

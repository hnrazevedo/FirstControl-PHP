<?php

namespace App\Rules;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class User
{
    public function __construct()
    {
        Validator::add($this,function(Rules $rules){
            $rules->action('login')
                  ->field('log_username',['minlength'=>1,'maxlength'=>20 ,'required'=>true])
                  ->field('log_password',['minlength'=>1,'maxlength'=>20,'required'=>true]);

            $rules->action('recover')
                  ->field('rec_email',['minlength'=>1,'maxlength'=>100,'filter'=>FILTER_VALIDATE_EMAIL,'required'=>true]);

            $rules->action('reset')
                  ->field('res_code',['minlength'=>40, 'maxlength'=> 40, 'required'=>true])
                  ->field('res_password',['minlength'=>1, 'maxlength' => 20,'required'=>true])
                  ->field('res_password2',['equals'=>'res_password','minlength'=>1,'maxlength'=>20,'required'=>true]);

            $rules->action('register')
                  ->field('new_userphoto',['regex'=>'/^data:image\/[^;]+;base64[^"]+$/','required'=>false])
                  ->field('new_name',['minlength'=>1,'maxlength'=>50,'required'=>true])
                  ->field('new_username',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->field('new_email',['minlength'=>1,'maxlength'=>100,'filter'=>FILTER_VALIDATE_EMAIL,'required'=>true])
                  ->field('new_password',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->field('new_password2',['equals'=>'new_password','minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->field('new_birth',['minlength'=>1,'maxlength'=>10,'regex'=>'/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/','required'=>true]);

            $rules->action('update')
                  ->field('edit_email',['minlength'=>1,'maxlength'=>100,'filter'=>FILTER_VALIDATE_EMAIL,'required'=>true])
                  ->field('edit_oldpassword',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->field('edit_password',['minlength'=>1,'maxlength'=>20,'required'=>false])
                  ->field('edit_password2',['equals'=>'edit_password','minlength'=>1,'maxlength'=>20,'required'=>false]);

            $rules->action('edition')
                  ->field('edit_userphoto',['regex'=>'/^data:image\/[^;]+;base64[^"]+$/','required'=>false])
                  ->field('edit_id',['minlength'=>1,'maxlength'=>11,'regex'=>'/^[0-9]{1,11}$/','required'=>true])
                  ->field('edit_name',['minlength'=>1,'maxlength'=>50,'required'=>true])
                  ->field('edit_username',['minlength'=>1,'maxlength'=>20,'required'=>true])
                  ->field('edit_email',['minlength'=>1,'maxlength'=>100,'filter'=>FILTER_VALIDATE_EMAIL,'required'=>true])
                  ->field('edit_birth',['minlength'=>1,'maxlength'=>10,'regex'=>'/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/','required'=>true])
                  ->field('edit_status',['minlength'=>1,'maxlength'=>1,'regex'=>'/^[0-1]{1}$/','required'=>true])
                  ->field('edit_password',['minlength'=>1,'maxlength'=>20,'required'=>false])
                  ->field('edit_password2',['equals'=>'edit_password','required'=>false]);
            return $rules;
        });
    }
}

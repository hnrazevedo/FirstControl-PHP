<?php

namespace HnrAzevedo\Validator;

use HnrAzevedo\Validator\Validator;
use HnrAzevedo\Validator\Rules;

Class User{

	public function __construct()
	{
		Validator::add($this,function(Rules $rules)
		{
            $rules->setAction('login')
                  ->addField('email',['minlength'=>1,'filter'=>FILTER_VALIDATE_EMAIL,'required'=>true])
                  ->addField('senha',['index'=>2,'minlength'=>6,'maxlength'=>20,'required'=>true])
				  ->addField('conected',['index'=>3,'minlength'=>2,'maxlength'=>2,'required'=>false]);

		    $rules->setAction('register')
				  ->addField('c_nome_completo',['minlength'=>1,'maxlenght'=>100,'required'=>true])
				  ->addField('c_nome_canal',['minlength'=>1,'maxlenght'=>40,'required'=>true])
				  ->addField('c_email',['filter'=>FILTER_VALIDATE_EMAIL,'required'=>true])
				  ->addField('c_data_nascimento',['regex'=>'/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/','required'=>true])
				  ->addField('c_celular',['regex'=>'/^\([0-9]{2}\) [0-9]{5}\-[0-9]{4}$/','required'=>true])
				  ->addField('c_senha',['minlength'=>8,'maxlength'=>12,'required'=>true])
				  ->addField('c_confirmar_senha',['minlength'=>8,'equals'=>'c_senha','required'=>true]);

			return $rules;
        });

    }
}

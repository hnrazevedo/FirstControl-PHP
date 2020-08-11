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
                  ->addField('log_username',['maxlength'=>20 ,'required'=>true])
                  ->addField('log_password',['maxlength'=>20,'required'=>true]);

			return $rules;
        });

    }
}

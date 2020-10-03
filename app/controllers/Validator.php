<?php

namespace App\Controller;

class Validator
{
    public function work()
    {
        $json = \HnrAzevedo\Validator\Validator::namespace('App\\Rules')->toJson($_POST);
        $script = "Validator.load(document.querySelector('form[provider=\"{$_POST['PROVIDER']}\"][role=\"{$_POST['ROLE']}\"]'),{$json});";
        echo json_encode(['success'=>$script]);
    }
}

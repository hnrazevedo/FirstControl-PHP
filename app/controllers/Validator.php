<?php

namespace App\Controller;

class Validator
{
    public function work()
    {
        $json = \HnrAzevedo\Validator\Validator::namespace('App\\Rules')->toJson($_POST);
        $script = "Validator.load(document.querySelector('form#{$_REQUEST['ID']}'),{$json});";
        echo json_encode(['success'=>$script]);
    }
}

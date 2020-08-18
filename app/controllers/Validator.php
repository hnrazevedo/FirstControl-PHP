<?php

namespace Controller;

use Engine\Util;
use Exception;
use HnrAzevedo\Validator\Validator as Sys_Validator;


class Validator{

    public function work()
    {
        $data = Util::getData()['POST'];
        if(!array_key_exists('provider',$data) || !array_key_exists('role',$data)){
            throw new Exception('O servidor não recebeu as informações necessárias para recuperar o validador solicitado.');
        }

        $json = Sys_Validator::toJson($data);
        $script = "Validate(document.querySelector('form[provider=\"{$data['provider']}\"][role=\"{$data['role']}\"]'),{$json});";
        echo json_encode(['success'=>$script]);
    }

}

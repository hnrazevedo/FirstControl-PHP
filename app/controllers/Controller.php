<?php

namespace App\Controller;

use HnrAzevedo\Validator\Validator;
use Exception;

class Controller
{

    protected array $fail = [];

    private function checkMethod(string $method): void
    {
        if(!method_exists($this, $method)){
            throw new Exception("{$method} not found in ".get_class($this).".");
        }
    }

    public function executeData(): bool
    {        
        $this->ValidateData();

        if($this->checkFailData()){
            return false;
        }

        $method = $_POST['ROLE'];

        $this->checkMethod($method);

        call_user_func_array([$this,$method],  func_get_args());

        return true;
    }

    private function ValidateData(): void
    {
        $valid = Validator::namespace('App\\Rules')->execute($_POST);

        if(!$valid){
            foreach(Validator::getErrors() as $err => $message){
                $this->fail[] = [
                    'input' => array_keys($message)[0],
                    'message' => $message[array_keys($message)[0]]
                ]; 
            }
        }
    }

    private function checkFailData(): bool
    {
        if(count($this->fail) > 0 ){
            echo json_encode([
                'error'=> $this->fail
            ]);
        }
        return (count($this->fail) > 0 );
    }

}

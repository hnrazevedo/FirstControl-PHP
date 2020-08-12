<?php

namespace Controller;

use HnrAzevedo\Viewer\Viewer;
use Model\User as Model;
use Engine\Util;
use Exception;


class User{

    private ?Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function logof()
    {
        unset($_SESSION['user']);
        setcookie('user',null,-1,'/');
        header('Location: /');
    }

    private function check_method(string $method)
    {
        if(!method_exists($this,$method)){
            throw new Exception("{$method} not found in ".get_class($this).".");
        }
    }

    public function method()
    {
        $method = Util::getData()['POST']['role'];

        $this->check_method($method);

        $this->$method();
    }

    public function login()
    {
        try{
            $data = Util::getData()['POST'];
            $user = $this->entity->find()->where(['username','=',$data['log_username']])->execute();
    
            if($user->getCount() === 0){
                throw new Exception('User not found.');
            }
        }catch(Exception $er){
            echo json_encode([
                'error' =>
                    [
                        'message' => $er->getMessage()
                    ]
            ]);
        }
    }

}

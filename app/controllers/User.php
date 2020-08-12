<?php

namespace Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use Model\User as Model;
use Engine\Util;
use Exception;


class User extends Controller{

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

    

    public function login()
    {
        try{
            $data = json_decode(Util::getData()['POST']['data'],true);

            $user = $this->entity->find()->where(['username','=',$data['log_username']])->execute();
    
            if($user->getCount() === 0){
                throw new Exception('User not found.');
            }

            $user = $user->toEntity();

            if(!password_verify($data['log_password'], $user->password)){
                throw new Exception('Invalid password.');
            }
        
            $_SESSION['user'] = $user;

            


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

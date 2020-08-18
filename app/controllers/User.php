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

    public function logout()
    {
        unset($_SESSION['user']);
        setcookie('user',null,-1,'/');
        header('Location: /');
    }

    public function login()
    {
        try{

            $data = json_decode(Util::getData()['POST']['data'],true);

            $user = $this->entity->find()->where([
                ['username','=',$data['log_username']],
                ['status','=',1]
            ])->execute();
    
            if($user->getCount() === 0){
                throw new Exception('User not found.');
            }

            $user = $user->toEntity();

            if(!password_verify($data['log_password'], $user->password)){
                throw new Exception('Invalid password.');
            }
        
            $_SESSION['user'] = serialize($user);

            echo json_encode([
                'script' => 'window.location.href="/dashboard";'
            ]);

        }catch(Exception $er){

            echo json_encode([
                'error' =>
                    [
                        'message' => $er->getMessage()
                    ]
            ]);

        }
    }

    public function dashboard()
    {
        Viewer::create(SYSTEM['basepath'].'app/views/')->render('dashboard',['pageID'=>1]);
    }

    public function view_login()
    {
        if(!empty($_SESSION['user'])){
            header('Location: /dashboard');
            return true;
        }
        
        Viewer::create(SYSTEM['basepath'].'app/views/user/')->render('login');
    }

    public function admin_register(array $data)
    {
        try{

            $data = json_decode($data['data'],true);

            $this->entity->name = $data['new_name'];
            $this->entity->username = $data['new_username'];
            $this->entity->email = $data['new_email'];
            $this->entity->birth = $data['new_birth'];
            $this->entity->password = password_hash($data['new_password'], PASSWORD_DEFAULT);
            $this->entity->type = 0;
            $this->entity->status = 1;
            $this->entity->code = sha1($data['new_email']);
            $this->entity->register = date('Y-m-d H:i:s');

            $this->entity->persist();

            echo json_encode([
                'success' => [
                    'message' => 'Usuário registrado com sucesso!'
                ],
                'reset' => true,
                'script' => "window.dataTables.dataAdd('table_list_user', ['<input type=\"checkbox\">','{$this->entity->id}','{$this->entity->name}','{$this->entity->username}','{$this->entity->email}','{$this->entity->birth}','{$this->entity->register}','{$this->entity->status}','{$this->entity->type}']);"
            ]);

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

<?php

namespace App\Controller;

use HnrAzevedo\Viewer\Viewer;
use App\Model\User as Model;
use Exception;

class User extends Controller{
    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function viewDashboard()
    {
        $data = [
            'page' => '/user/dashboard',
            'title' => 'Dashboard',
            'breadcrumb' => [
                ['text' => 'Dashboard', 'active' => true]
            ]
        ];
        Viewer::path(SYSTEM['basepath'].'app/views/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function grid()
    {
        return [
            'page' => '/admin/list',
            'title' => 'Registros de usuários',
            'breadcrumb' => [
                ['text' => 'Administração', 'uri' => '/administracao/'],
                ['text' => 'Usuários', 'uri' => '/administracao/usuarios'],
                ['text' => 'Registros', 'active' => true]
            ],
            'tab' => [
                'id' => 'registersUsers',
                'title' => 'Registro de usuários',
                'href' => '/administracao/usuarios/',
                'uri' => '/administracao/usuario/listagem',
                'thead' => '<th>ID</th><th>Nome</th><th>Usuário</th><th>Email</th><th>Nascimento</th><th>Registro</th><th>Últ. Acesso</th><th>Acesso</th><th>Tipo</th>'
            ]
        ];
    }

    public function list()
    {
        $users = $this->entity->find()->except(['password','code'])->where([
            ['id','<>', 1]
        ])->execute()->toEntity();

        $users = (is_array($users)) ? $users : [$users];

        if(is_null($users[0])){
            return false;
        }

        $return = [];
        foreach($users as $user => $result){
            $date = [];
            foreach($result->getData() as $field => $data){
                if($result->$field != null){
                    switch($field){
                        case 'type':
                            $date[] = ($result->$field) ? 'Administrador' : 'Comum';
                        break;
                        case 'status':
                            $date[] = ($result->$field) ? 'Liberado' : 'Bloqueado';
                        break;
                        default:
                            $date[] = $result->$field;
                        break;
                    }
                }
            }
            $return[] = array_values($date);
        }
        return $return;
    }

    public function details($id)
    {
        $user = $this->entity->find($id)->where([
            ['id','<>',1]
        ])->execute()->toEntity();

        if(null === $user){
            throw new Exception('Usuário não encontrado.', 404);
        }

        return [
            'page' => '/user/details',
            'title' => 'Detalhes de usuário',
            'userView' => $user,
            'breadcrumb' => [
                ['text' => 'Administração', 'uri' => '/administracao/'],
                ['text' => 'Usuários', 'uri' => '/administracao/usuarios'],
                ['text' => 'Detalhes', 'active' => true],
            ]
        ];
    }

    public function logout()
    {
        unset($_SESSION['user']);
        setcookie('user',null,-1,'/');
        header('Location: /');
    }

    public function login($username, $password)
    {
        try{
            $user = $this->entity->find()->where([
                ['username','=',$username]
            ])->execute();
    
            if($user->getCount() === 0){
                throw new Exception('User not found.');
            }

            $user = $user->toEntity();

            if($user->status == 0){
                throw new Exception('User is blocked.');
            }         

            if(!password_verify($password, $user->password)){
                throw new Exception('Invalid password.');
            }

            $user->lastaccess = date('Y-m-d H:i:s');
            $user->save();

        
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
        $data = [
            'page' => '/user/dashboard',
            'title' => 'Dashboard',
            'pageID' => 1
        ];

        Viewer::path(SYSTEM['basepath'].'app/views/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function viewLogin()
    {
        if(!empty($_SESSION['user'])){
            header('Location: /dashboard');
            return true;
        }

        $data = [
            'page' => '/user/login.form',
            'title' => 'Acessar',
            'breadcrumb' => [
                ['text' => 'Acessar', 'active' => true]
            ]
        ];
        
        Viewer::path(SYSTEM['basepath'].'app/views/')->render('index', array_merge($data, $_SESSION['view']['data']));
    }


    public function adminRegister(array $data)
    {
        try{

            $data = $_POST;

            $this->entity->name = $data['new_name'];
            $this->entity->username = $data['new_username'];
            $this->entity->email = $data['new_email'];
            $this->entity->birth = $data['new_birth'];
            $this->entity->password = password_hash($data['new_password'], PASSWORD_DEFAULT);
            $this->entity->type = 0;
            $this->entity->status = 1;
            $this->entity->code = sha1($data['new_email']);
            $this->entity->register = date('Y-m-d H:i:s');
            $this->entity->lastaccess = date('Y-m-d H:i:s');

            $this->entity->persist();

            echo json_encode([
                'success' => [
                    'message' => 'Usuário registrado com sucesso!'
                ],
                'reset' => true,
                'script' => "setTimeout(function(){ window.location.href='/administracao/usuarios'; },2000);"
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

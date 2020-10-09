<?php

namespace App\Controller;

use HnrAzevedo\Viewer\Viewer;
use App\Model\User as Model;

class User extends Controller
{
    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function viewRegister()
    {
        $this->view([
            'page' => '/user/register.form',
            'title' => 'Novo usuário',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Usuário', 'uri' => '/usuario'],
                ['text' => 'Novo usuário', 'active' => true]
            ]
        ]);
    }

    public function viewData()
    {
        $data = [
            'page' => '/user/update.form',
            'title' => 'Minha conta',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Minha conta', 'active' => true]
            ]
        ];
        Viewer::path(SYSTEM['basepath'].'app/views/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function viewDashboard()
    {
        $data = [
            'page' => '/user/dashboard',
            'title' => 'Painel principal',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'active' => true]
            ]
        ];
        Viewer::path(SYSTEM['basepath'].'app/views/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function viewList(): void
    {
        $this->view([
            'page' => '/admin/list',
            'title' => 'Registros de usuários',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Usuário', 'uri' => '/usuario'],
                ['text' => 'Listagem', 'active' => true]
            ],
            'tab' => [
                'id' => 'registersUsers',
                'title' => 'Registro de usuários',
                'href' => '/usuario/',
                'uri' => '/usuario/listagem',
                'thead' => '<th>ID</th><th>Nome</th><th>Usuário</th><th>Email</th><th>Nascimento</th><th>Registro</th><th>Últ. Acesso</th><th>Acesso</th><th>Tipo</th>'
            ]
        ]);
    }

    public function viewMenu(): void
    {
        $this->view([
            'page' => '/user/menu',
            'title' => 'Usuários',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Usuário', 'active' => true]
            ]
        ]);
    }

    public function jsonList(): void
    {
        $users = $this->entity->find()->except(['password','code'])->where([
            ['id','<>', 1]
        ])->execute()->toEntity();

        $users = (is_array($users)) ? $users : [$users];

        if(is_null($users[0])){
            return;
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
        echo json_encode($return);
    }

    public function viewDetails($id): void
    {
        $user = $this->entity->find($id)->where([
            ['id','<>',1]
        ])->execute()->toEntity();

        if(null === $user){
            throw new \Exception('Usuário não encontrado.', 404);
        }

        $this->view([
            'page' => '/user/details',
            'title' => 'Detalhes de usuário',
            'userView' => $user,
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Usuário', 'uri' => '/usuario'],
                ['text' => 'Listagem', 'uri' => '/usuario/listagem'],
                ['text' => 'Detalhes', 'active' => true],
            ]
        ]);
    }

    public function logout(): void
    {
        $_SESSION = [];
        setcookie('user',null,-1,'/');
        header('Location: /');
    }

    public function login($username, $password): void
    {
        try{

            $this->ValidateData();

            if($this->checkFailData()){
                return;
            }

            $user = $this->entity->find()->where([
                ['username','=',$username]
            ])->execute();
    
            if($user->getCount() === 0){
                throw new \Exception('User not found.');
            }

            $user = $user->toEntity();

            if($user->status == 0){
                throw new \Exception('User is blocked.');
            }         

            if(!password_verify($password, $user->password)){
                throw new \Exception('Invalid password.');
            }

            $user->lastaccess = date('Y-m-d H:i:s');
            $user->save();

        
            $_SESSION['user'] = serialize($user);

            echo json_encode([
                'script' => 'window.location.href="/dashboard";'
            ]);

        }catch(\Exception $er){
            echo json_encode([
                'error' =>
                    [
                        'message' => $er->getMessage()
                    ]
            ]);
        }
    }

    public function viewLogin(): void
    {
        if(isset($_SESSION['user'])){
            header('Location: /dashboard');
            return;
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


    public function register(): void
    {
        try{
            $this->entity->name = $_POST['new_name'];
            $this->entity->username = $_POST['new_username'];
            $this->entity->email = $_POST['new_email'];
            $this->entity->birth = $_POST['new_birth'];
            $this->entity->password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $this->entity->type = 0;
            $this->entity->status = 1;
            $this->entity->code = sha1($_POST['new_email']);
            $this->entity->register = date('Y-m-d H:i:s');
            $this->entity->lastaccess = date('Y-m-d H:i:s');

            $this->entity->persist();

            echo json_encode([
                'success' => [
                    'message' => 'Usuário registrado com sucesso!'
                ],
                'reset' => true,
                'script' => "setTimeout(function(){ window.location.href='/usuario'; },2000);"
            ]);

        }catch(\Exception $er){
            echo json_encode([
                'error' =>
                    [
                        'message' => $er->getMessage()
                    ]
            ]);
        }
    }

    public function update(): void
    {
        try{
            if(!isset($_SESSION['user'])){
                throw new \Exception('Usuário deve estar logado');
            }

            $user = unserialize($_SESSION['user']);

            if(!password_verify($_POST['edit_oldpassword'], $user->password)){
                throw new \Exception('Senha atual inválida');
            }

            $user->email = $_POST['edit_email'];

            if(strlen($_POST['edit_password']) > 0){
                $user->password = password_hash($_POST['edit_password'], PASSWORD_DEFAULT);
            }

            $user->save();

            $_SESSION['user'] = serialize($user);

            echo json_encode([
                'success' => [
                    'message' => 'Informações atualizadas com sucesso!'
                ],
                'reset' => true,
                'script' => "setTimeout(function(){ window.location.href='/usuario/minha-conta'; },2000);"
            ]);

        }catch(\Exception $er){
            echo json_encode([
                'error' =>
                    [
                        'message' => $er->getMessage()
                    ]
            ]);
        }
    }

    public function updateUser()
    {
        $user = $this->entity->find($_POST['edit_id'])->execute()->toEntity();

        if(null === $user){
            throw new \Exception('Usuário não encontrado');
        }

        if($user->type == 1 && (unserialize($_SESSION['user']))->id != 1){
            throw new \Exception('Usuário é um administrador<br>Atualização não permitida');
        }

        if(strlen($_POST['edit_password'] > 0)){
            $user->password = password_hash($_POST['edit_password'], PASSWORD_DEFAULT);
        }
        
        $user->status = $_POST['edit_status'];
        $user->type = $_POST['edit_type'];

        $user->save();

        echo json_encode([
            'success' => [
                'message' => 'Usuário atualizado com sucesso'
            ],
            'script' => 'setTimeout(function(){ window.location.href="/usuario/listagem"; },2000);'
        ]);
    }

}

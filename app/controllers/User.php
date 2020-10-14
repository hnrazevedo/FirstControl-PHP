<?php

namespace App\Controller;

use HnrAzevedo\Viewer\Viewer;
use App\Controller\Authorization as AuthorizationController;
use App\Model\User as Model;
use App\Engine\Mail;
use App\Helpers\Converter;

class User extends Controller
{
    use Converter;

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

    public function viewAccount()
    {
        $this->view([
            'page' => '/user/update.form',
            'title' => 'Minha conta',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Usuário', 'uri' => '/usuario'],
                ['text' => 'Minha conta', 'active' => true]
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
                'thead' => '<th>ID</th><th>Nome</th><th>Usuário</th><th>Email</th><th>Nascimento</th><th>Registro</th><th>Últ. Acesso</th><th>Acesso</th><th>Ações</th>'
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
        $users = $this->entity->find()->except(['password','code','photo'])->where([
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
                        case 'status':
                            $date[] = ($result->$field) ? 'Liberado' : 'Bloqueado';
                        break;
                        default:
                            $date[] = $result->$field;
                        break;
                    }
                }
            }
            $item = array_values($date);
            $item[] = "<a href='{$item[0]}/permissoes'>Permissões</a> - <a href='{$item[0]}/edicao'>Editar</a>";
            $return[] = $item;
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

    public function viewEdition($id): void
    {
        $user = $this->entity->find($id)->where([
            ['id','<>',1]
        ])->execute()->toEntity();

        if(null === $user){
            throw new \Exception('Usuário não encontrado.', 404);
        }

        $this->view([
            'page' => '/user/edition.form',
            'title' => 'Edição de usuário',
            'userView' => $user,
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Usuário', 'uri' => '/usuario'],
                ['text' => 'Listagem', 'uri' => '/usuario/listagem'],
                ['text' => 'Edição', 'active' => true],
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
            ])->execute()->toEntity();
    
            if(null === $user){
                throw new \Exception('Usuário não encontrado');
            }

            if($user->status == 0){
                throw new \Exception('Usuário bloqueado');
            }         

            if(!password_verify($password, $user->password)){
                throw new \Exception('Senha inválida');
            }

            $user->code = sha1($user->email).'|'.date('Y-m-d');
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

        $this->view([
            'page' => '/user/login.form',
            'title' => 'Acessar',
            'breadcrumb' => [
                ['text' => 'Acessar', 'active' => true]
            ]
        ]);
    }

    public function viewRecover(): void
    {
   //     echo file_get_contents(SYSTEM['basepath'].'app/views/user/recover.mail.php');
        //return;
        $this->view([
            'page' => '/user/recover.form',
            'title' => 'Recuperar senha',
            'breadcrumb' => [
                ['text' => 'Recuperar senha', 'active' => true]
            ]
        ]);
    }

    public function recover($email): void
    {
        $user = $this->entity->find()->where([
            ['email','=',$email]
        ])->execute()->toEntity();
   
        if(null === $user){
            throw new \Exception('Usuário não encontrado');
        }

        $code = sha1(date('d/m/Y H:i:s').$user->email).'|'.date('Y-m-d');

        $user->code = $code;
        $user->save();

        $html = file_get_contents(SYSTEM['basepath'].'/app/views/user/recover.mail.php');
        $html = str_replace('{{ $code }}', $code, $html);
        $html = str_replace('{{ $system.uri }}', SYSTEM['uri'], $html);

        $mail = new Mail('suporte');
        $mail->addTo('address', $email, $user->name)
             ->addTo('from', $email, $user->name)
             ->addSubject('Recuperação de senha')
             ->addContent($html, htmlspecialchars($html))
             ->send();
        
        if($mail->fail()){
            throw $mail->getError();
        }

        echo json_encode([
            'success' => [
                'message' => 'Uma mensagem contendo instruções para recuperação de senha foi enviada para seu email'
            ],
            'reset'=>true,
            'script' => "setTimeout(function(){ window.location.href='/' },5000);"
        ]);          
            
    }

    public function register(): void
    {
        try{
            $this->entity->name = $_POST['new_name'];
            $this->entity->username = $_POST['new_username'];
            $this->entity->email = $_POST['new_email'];
            $this->entity->birth = $_POST['new_birth'];
            $this->entity->password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $this->entity->status = 1;
            $this->entity->code = sha1($_POST['new_email']).'|'.date('Y-m-d');
            $this->entity->register = date('Y-m-d H:i:s');
            $this->entity->lastaccess = date('Y-m-d H:i:s');
            $this->entity->photo = 'default.svg';

            if(strlen($_POST['new_userphoto']) > 0){
                $file = $this->replaceBase64($_POST['new_userphoto']);
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR.$_POST['new_username'].'.'.$file['ext'];
                if(file_put_contents($tmpPhoto, $file['data'])){
                    $this->entity->photo = $_POST['new_username'].'.'.$file['ext'];
                }
            }

            $this->entity->persist();

            (new AuthorizationController())->update('Ajax', $this->entity->id, 'user|update');

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

    public function edition()
    {
        $user = $this->entity->find($_POST['edit_id'])->execute()->toEntity();

        if(null === $user){
            throw new \Exception('Usuário não encontrado');
        }

        if((unserialize($_SESSION['user']))->id != 1){
            throw new \Exception('Usuário é um administrador<br>Atualização não permitida');
        }

        $user->password = (strlen($_POST['edit_password'] > 0)) ? password_hash($_POST['edit_password'], PASSWORD_DEFAULT) : $user->password;
        $user->name = $_POST['edit_name'];
        $user->username = $_POST['edit_username'];
        $user->email = $_POST['edit_email'];
        $user->birth = $_POST['edit_birth'];
        $user->status = $_POST['edit_status'];

        if(strlen($_POST['edit_userphoto']) > 0){
            $file = $this->replaceBase64($_POST['edit_userphoto']);
            $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR.$_POST['edit_username'].'.'.$file['ext'];
            if(file_put_contents($tmpPhoto, $file['data'])){
                $user->photo = $_POST['edit_username'].'.'.$file['ext'];
            }
        }

        $user->save();

        

        echo json_encode([
            'success' => [
                'message' => 'Usuário editado com sucesso'
            ],
            'reset'=>true,
            'script' => 'setTimeout(function(){ window.location.href="/usuario/listagem"; },2000);'
        ]);
    }

}

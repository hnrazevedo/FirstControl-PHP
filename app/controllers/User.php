<?php

namespace App\Controller;

use App\Controller\Authorization as AuthorizationController;
use App\Model\User as Model;
use App\Engine\Mail;
use App\Helpers\Converter;
use App\Controller\Helper\{UserViewer, UserChecker};

class User extends Controller
{
    use Converter,
        UserViewer,
        UserChecker;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function jsonList(): void
    {
        $users = $this->entity->find()->except(['password','code','photo'])->where([
            ['id','<>', 1]
        ])->execute()->toEntity();

        $users = (is_array($users)) ? $users : [$users];

        $this->throwUser($users[0]);

        $return = [];
        foreach($users as $user => $result){
            $item = array_values($this->mountItem($result));
            $item[] = "<a href='{$item[0]}/permissoes'>Permissões</a> - <a href='{$item[0]}/edicao'>Editar</a>";
            $return[] = $item;
        }
        echo json_encode($return);
    }

    private function mountItem($result): array
    {
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
        return $date;
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
    
            $this->throwUser($user)
                 ->throwStatus($user->status)
                 ->throwPassword($password, $user->password);

            $user->code = sha1($user->email).'|'.date('Y-m-d H:i:s');
            $user->lastaccess = date('Y-m-d H:i:s');
            $user->save();
        
            $_SESSION['user'] = serialize($user);

            echo json_encode(['script' => 'window.location.href="/dashboard";']);
        }catch(\Exception $er){
            echo json_encode(['error' =>['message' => $er->getMessage()]]);
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

    public function recover($email): void
    {
        $user = $this->entity->find()->where([
            ['email','=',$email]
        ])->execute()->toEntity();
   
        $this->throwUser($user);

        $code = sha1(date('d/m/Y H:i:s').$user->email);

        $user->code = $code.'|'.date('Y-m-d H:i:s');
        $user->save();

        $html = file_get_contents( SYSTEM['basepath'] . '/app/views/mail/recover/recover.mail.html');
        $html = str_replace('{{ $code }}', $code, $html);
        $html = str_replace('{{ $system.uri }}', SYSTEM['uri'], $html);

        $nohtml = file_get_contents( SYSTEM['basepath'] . '/app/views/mail/recover/recover.mail.txt');
        $nohtml = str_replace('{{ $code }}', $code, $nohtml);
        $nohtml = str_replace('{{ $system.uri }}', SYSTEM['uri'], $nohtml);

        $mail = new Mail('suporte');
        $mail->addTo('address', $email, $user->name)
             ->addTo('from', $email, $user->name)
             ->addSubject('Recuperação de senha')
             ->addContent($html, $nohtml)
             ->send();
        
        $this->throwMail($mail);

        echo json_encode([
            'success' => [
                'message' => 'Uma mensagem contendo instruções para recuperação de senha foi enviada para seu email'
            ],
            'reset'=>true,
            'script' => "setTimeout(function(){ window.location.href='/' },5000);"
        ]);          
            
    }

    public function reset($code, $password): void
    {
        $user = $this->entity->find()->where([
            ['code', 'like', $code.'%']
        ])->execute()->toEntity();
   
        $this->throwUser($user);

        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->code = sha1(date('d/m/Y H:i:s').$user->email).'|'.date('Y-m-d H:i:s');
        $user->save();

        $html = file_get_contents( SYSTEM['basepath'] . '/app/views/mail/reseted/reseted.mail.html');
        $html = str_replace('{{ $code }}', $code, $html);
        $html = str_replace('{{ $user.name }}', $user->name, $html);
        $html = str_replace('{{ $system.uri }}', SYSTEM['uri'], $html);

        $nohtml = file_get_contents( SYSTEM['basepath'] . '/app/views/mail/reseted/reseted.mail.txt');
        $nohtml = str_replace('{{ $code }}', $code, $nohtml);
        $nohtml = str_replace('{{ $user.name }}', $user->name, $nohtml);
        $nohtml = str_replace('{{ $system.uri }}', SYSTEM['uri'], $nohtml);

        $mail = new Mail('suporte');
        $mail->addTo('address', $user->email, $user->name)
             ->addTo('from', $user->email, $user->name)
             ->addSubject('Redefinição de senha')
             ->addContent($html, $nohtml)
             ->send();

        $this->throwMail($mail);

        echo json_encode([
            'success' => [
                'message' => 'Senha redefinida com sucesso'
            ],
            'reset'=>true,
            'script' => "setTimeout(function(){ window.location.href='/' }, 2000);"
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
            $user = unserialize($_SESSION['user']);

            $this->throwPassword($_POST['edit_oldpassword'], $user->password);

            $user->email = $_POST['edit_email'];
            $user->password = (strlen($_POST['edit_password']) > 0) ? password_hash($_POST['edit_password'], PASSWORD_DEFAULT) : $user->password;
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

        $this->throwUser($user)->throwAdmin();

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

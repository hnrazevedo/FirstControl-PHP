<?php

namespace App\Controller;

use App\Controller\Authorization as AuthorizationController;
use App\Model\User as Model;
use App\Engine\Mail;
use App\Engine\Util;
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
        $users = $this->entity->find()->except(['password', 'code', 'photo'])->where([
            ['id', '<>', 1]
        ])->execute()->toEntity();

        $users = $this->getArray($users);

        $this->throwUser($users[0]);

        $return = [];
        foreach($users as $user => $result){
            $item = array_values($this->mountItem($result));
            $item[] = "<a href='{$item[0]}' class='btn btn-primary list' data-toggle='tooltip' title='Detalhes'><i class='bx bx-show'></i></a>
                       <a href='{$item[0]}/edicao' class='btn btn-primary list' data-toggle='tooltip' title='Editar'><i class='bx bxs-pencil'></i></a>
                       <a href='{$item[0]}/remover' class='btn btn-primary list' data-toggle='tooltip' title='Remover'><i class='bx bx-trash'></i></a>
                       <a href='{$item[0]}/permissoes' class='btn btn-primary list' data-toggle='tooltip' title='Permissões'><i class='bx bx-key'></i></a>";
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
        $_SESSION['alert'] = [
            'message' => 'Sessão finalizada com sucesso',
            'class' => 'success'
        ];
        setcookie('user',null,-1,'/');
        header('Location: /');
    }

    public function login($username, $password): void
    {
        $user = $this->entity->find()->where([
            ['username', '=', $username]
        ])->execute()->toEntity();
    
        $this->throwUser($user)
             ->throwStatus($user->status)
             ->throwPassword($password, $user->password);

        $user->code = sha1($user->email).'|'.date('Y-m-d H:i:s');
        $user->lastaccess = date('Y-m-d H:i:s');
        $user->save();
        
        $_SESSION['user'] = serialize($user);

        echo json_encode(['script' => 'window.location.href="/dashboard";']);
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
            ['email', '=', $email]
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

        $_SESSION['alert'] = [
            'message' => 'Uma mensagem contendo instruções para recuperação de senha foi enviada para seu email',
            'class' => 'success'
        ];

        echo json_encode([
            'script' => "window.location.href='/';"
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

        $_SESSION['alert'] = [
            'message' => 'Senha redefinida com sucesso',
            'class' => 'success'
        ];

        echo json_encode([
            'script' => "window.location.href='/';"
        ]);          
            
    }

    public function register(): void
    {
        $tmpPhoto = null;
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

            $_SESSION['alert'] = [
                'message' => 'Usuário registrado com sucesso',
                'class' => 'success'
            ];

            echo json_encode([
                'script' => "window.location.href='/usuario';"
            ]);

        }catch(\Exception $er){
            Util::delete($tmpPhoto);
            throw $er;
        }
    }

    public function update(): void
    {
        $user = unserialize($_SESSION['user']);

        $this->throwPassword($_POST['edit_oldpassword'], $user->password);

        $user->email = $_POST['edit_email'];
        $user->password = (strlen($_POST['edit_password']) > 0) ? password_hash($_POST['edit_password'], PASSWORD_DEFAULT) : $user->password;
        $user->save();

        $_SESSION['user'] = serialize($user);

        $_SESSION['alert'] = [
            'message' => 'Informações atualizadas com sucesso',
            'class' => 'success'
        ];

        echo json_encode([
            'script' => "window.location.href='/usuario/minha-conta';"
        ]);
    }

    public function edition(): void
    {
        $oldPhoto = null;
        $tmpPhoto = null;

        try{
            $user = $this->entity->find(intval($_POST['edit_id']))->execute()->toEntity();

            $this->throwUser($user)
                 ->throwAdmin();

            $oldPhoto = $user->photo;
    
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

            if($oldPhoto !== $tmpPhoto){
                Util::delete($oldPhoto);
            }

            $_SESSION['alert'] = [
                'message' => 'Usuário editado com sucesso',
                'class' => 'success'
            ];
    
            echo json_encode([
                'script' => 'window.location.href="/usuario/listagem";'
            ]);

        }catch(\Exception $er){
            Util::delete($tmpPhoto);
            throw $er;
        }
    }

    public function remove(string $id): void
    {
        $user = $this->entity->find(intval($id))->execute()->toEntity();

        $this->throwUser($user);

        (new AuthorizationController())->removeByUser($user->id);

        $user->remove(true);

        $_SESSION['alert'] = [
            'message' => 'Usuário removido com sucesso',
            'class' => 'success'
        ];

        header('Location: /usuario/listagem');
    }

}

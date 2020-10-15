<?php

namespace App\Controller\Helper;

use App\Model\User as Model;

trait UserViewer
{
    use Viewer, UserChecker;

    protected Model $entity;

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
        $this->view([
            'page' => '/user/update.form',
            'title' => 'Minha conta',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Minha conta', 'active' => true]
            ]
        ]);
    }

    public function viewDashboard()
    {
        $this->view([
            'page' => '/user/dashboard',
            'title' => 'Painel principal',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'active' => true]
            ]
        ]);
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

    public function viewRecover(): void
    {
        $this->view([
            'page' => '/user/recover.form',
            'title' => 'Recuperar senha',
            'breadcrumb' => [
                ['text' => 'Recuperar senha', 'active' => true]
            ]
        ]);
    }

    public function viewDetails($id): void
    {
        $user = $this->entity->find($id)->where([
            ['id','<>',1]
        ])->execute()->toEntity();

        $this->checkUser($user);

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

        $this->checkUser($user);

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

    public function viewReset($code): void
    {
        $user = $this->entity->find()->only('code')->where([
            ['code', 'like', $code.'%']
        ])->execute()->toEntity();

        $this->checkUser($user);
        
        $diff = (new \DateTime(explode('|',$user->code)[1]))->diff(new \DateTime(date('Y-m-d H:i:s')));
        $hours = $diff->h + ($diff->days * 24);
        
        if($hours >= 24){
            throw new \Exception('Link de redefinição de senha expirado', 403);
        }

        $this->view([
            'page' => '/user/reset.form',
            'title' => 'Redefinir senha',
            'code' => $code,
            'breadcrumb' => [
                ['text' => 'Redefinir senha', 'active' => true]
            ]
        ]);
    }

}

<?php

namespace App\Controller;

use HnrAzevedo\Viewer\Viewer;
use App\Model\Authorization as Model;
use App\Model\User as UserModel;
use App\Model\Permission as Permission;
use Exception;

class Authorization extends Controller
{
    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function details($id)
    {
        $this->view([
            'page' => '/config/authorization',
            'title' => 'Permissões',
            'permissions' => $this->list($id),
            'id' => $id,
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Usuário', 'uri' => '/usuario'],
                ['text' => 'Listagem', 'uri' => '/usuario/listagem'],
                ['text' => 'Permissões', 'active' => true]
            ]
        ]);
    }

    public function list($id): array
    {
        $user = (new UserModel())->find($id)->execute()->toEntity();

        if(null === $user){
            throw new Exception('Usuário não encontrado', 404);
        }

        $authozations = $this->entity->find()->where([
            ['user', '=', $id]
        ])->execute()->toEntity();

        if(null === $authozations){
            return [];
        }

        $authozations = (is_array($authozations)) ? $authozations : [$authozations];

        $permissions = [];
        foreach($authozations as $auth){
            $permissions[] = $auth->permission;
        }

        $permissions = (new Permission())->find()->where([
            ['id', 'IN' , $permissions]
        ])->execute()->toEntity();

        $permissions = (is_array($permissions)) ? $permissions : [$permissions];

        $active = [];

        foreach($permissions as $permission){
            $active[$permission->reference] = true;
        }

        return $active;
    }

    public function update($req, $user, $permission): void
    {
        if($user == 1){
            return;
        }

        $permission = (new Permission())->find()->where([
            ['reference', '=', $permission]
        ])->execute()->toEntity();

        if(null === $permission){
            throw new \Exception('Permissão não encontrada');
        }

        $authorization = $this->entity->find()->where([
            ['permission', '=', $permission->id],
            ['user', '=', $user]
        ])->execute()->toEntity();

        if(null === $authorization){
            $this->entity->user = $user;
            $this->entity->permission = $permission->id;
            $this->entity->persist();
            return;
        }

        $authorization->remove(true);
    }
}

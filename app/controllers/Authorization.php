<?php

namespace App\Controller;

use HnrAzevedo\Viewer\Viewer;
use App\Model\Authorization as Model;
use App\Model\User as UserModel;
use App\Model\Permission as PermissionModel;
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
            'permissionsView' => $this->list($id),
            'breadcrumb' => [
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
            ['user','=',$id]
        ])->execute()->toEntity();

        echo '<pre>';
        var_dump($authozations);


        die();
        
        return [

        ];
    }
}

<?php

namespace Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use Controller\User as User_Controller;
use Model\User as Model;
use Exception;


class Admin extends Controller{

    private ?Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function view_users()
    {
        $data = [
            'title' => 'Registros de usuários',
            'page' => '../admin/user/list',
            'pageID' => 2
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/admin/')->render('index',$data);
    }

    public function view_dashboard()
    {
        $data = [
            'title' => 'Painel de controle',
            'page' => '../admin/dashboard/dashboard',
            'pageID' => 3
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/admin/')->render('index',$data);
    }

    public function result_list(array $data)
    {
        switch($data['GET']['entity'])
        {
            case 'users':
                echo json_encode($this->getListUser());
                break;
            default:
                throw new Exception('Consulta de listagem incorreta.');
                break;
        }
    }

    public function getListUser()
    {
        $users = $this->entity->find()->except(['password','code'])->execute()->toEntity();
        $return = [];
        foreach($users as $user => $result){
            $date = [];
            foreach($result->getData() as $field => $data){
                
                if($result->$field != null){
                    $date[] = $result->$field;
                }

            }
            $return[] = array_values($date);
        }
        return $return;
    }

    public function user_register(array $data)
    {
        (new User_Controller())->admin_register($data['POST']); 
    }

    public function status_user(array $data)
    {
        $data = json_decode($data['POST']['data'],true);
        $selects = json_decode($data['dataselect']);

        $result = $this->entity->find()->where([
            ['id','in',$selects],
            'AND' => ['type','<>',1]
        ])->execute()->toEntity();

        $users = (is_array($result)) ? $result : [$result];

        $method = ($data['role'] == 'block') ? 'bloqueados' : '';
        $method = ($data['role'] == 'live') ? 'liberados' : $method;
        $method = ($data['role'] == 'remove') ? 'removidos' : $method;

        foreach($users as $user){
            if($data['role'] != 'remove'){
                $user->status = ($data['role'] == 'block') ? 0 : 1;
                $user->save();
            }else{
                $user->remove(true);
            }
        }

        echo json_encode([
            'success' => [
                'message' => "Usuários selecionados ${method} com sucesso!" 
            ],
            'script' => 'setTimeout(function(){window.location.href="/admin/users"},2000)'
        ]);
       
    }

}

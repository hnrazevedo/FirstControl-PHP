<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Controller\User as User_Controller;
use App\Model\User as Model;
use App\Engine\Util;
use Exception;


class Admin extends Controller{

    private ?Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function view_users($id)
    {
        if((strlen($id) > 0)){
            $this->viewUserById($id);
            return true;
        }

        $data = [
            'title' => 'Registros de usuários',
            'page' => '../admin/user/list',
            'pageID' => 2
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/admin/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    private function viewUserById(int $id)
    {
        $user = $this->entity->find($id)->execute()->toEntity();
        
        if(is_null($user)){
            throw new Exception('User not found.',404);
        }

        $data = [
            'title' => 'Registros de usuários',
            'page' => '../admin/user/details',
            'pageID' => 3,
            'user' => $user
        ];
        
        Viewer::create(SYSTEM['basepath'].'app/views/admin/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function view_dashboard()
    {
        $data = [
            'title' => 'Painel de controle',
            'page' => '../admin/dashboard/dashboard',
            'pageID' => 3
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/admin/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function result_list($entity)
    {
        switch($entity)
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

        $users = (is_array($users)) ? $users : [$users];

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

    public function user_register()
    {
        (new User_Controller())->admin_register(Util::getData()['POST']); 
    }

    public function status_user($role, $dataselect)
    {
        $selects = json_decode($dataselect);

        $result = $this->entity->find()->where([
            ['id','in',$selects],
            'AND' => ['type','<>',1]
        ])->execute()->toEntity();

        if(is_null($result)){
            echo json_encode([
                'success' => [
                    'message' => "Os usuários selecionados não atendem os critérios para tal ação." 
                ]
            ]);
            return true;
        }

        $users = (is_array($result)) ? $result : [$result];

        $method = ($role == 'block') ? 'bloqueados' : '';
        $method = ($role == 'live') ? 'liberados' : $method;
        $method = ($role == 'remove') ? 'removidos' : $method;

        foreach($users as $user){
            if($role != 'remove'){
                $user->status = ($role== 'block') ? 0 : 1;
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

<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Controller\User as User_Controller;
use App\Model\User as Model;
use App\Engine\Util;
use Exception;

class Admin extends Controller{

    private Model $entity;

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
            'page' => '../user/list',
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
            'pageID' => 4,
            'user' => $user
        ];
        
        Viewer::create(SYSTEM['basepath'].'app/views/user/')->render('details',array_merge($data, $_SESSION['view']['data']));
    }

    public function edit_user()
    {
        $data = json_decode(Util::getData()['POST']['data'],true);
        $user = $this->entity->find($data['edit_id'])->execute();

        if($user->getCount()===0){
            throw new Exception('User not found.');
        }

        $user = $user->toEntity();

        if($user->type === 1){
            throw new Exception('User is admin.<br>Update not allowed.');
        }

        $user->password = password_hash($data['edit_password'],PASSWORD_DEFAULT);

        $user->save();

        echo json_encode([
            'success' => [
                'message' => 'User updated successfully.<br>This page will be closed in 3s.'
            ],
            'script' => 'setTimeout(function(){window.close();},3000);'
        ]);
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
        $users = $this->entity->find()->except(['password','code'])->where([
            ['type','=','0']
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

        $method = '';
        
        foreach($users as $user){
            switch($role){
                case 'block':
                    $user->status = 0;
                    $user->save();
                    $method = 'bloqueados';
                break;
                case 'live':
                    $user->status = 1;
                    $user->save();
                    $method = 'liberados';
                break;
                default:
                    $user->remove(true);
                    $method = 'removidos';
                break;
            }
        }

        echo json_encode([
            'success' => [
                'message' => "Usuários selecionados ${method} com sucesso!" 
            ],
            'script' => 'setTimeout(function(){window.location.href="/users"},2000)'
        ]);
       
    }

}

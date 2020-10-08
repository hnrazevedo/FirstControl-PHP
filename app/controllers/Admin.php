<?php

namespace App\Controller;

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

    public function viewDashboard()
    {
        $data = [
            'page' => '/admin/dashboard',
            'title' => 'Administração',
            'breadcrumb' => [
                ['text' => 'Administração', 'active' => true]
            ]
        ];
        Viewer::path(SYSTEM['basepath'].'app/views/')->render('index', array_merge($data, $_SESSION['view']['data']));
    }

    public function viewRegisters()
    {
        $data = [
            'page' => '/admin/registers',
            'title' => 'Registros',
            'breadcrumb' => [
                ['text' => 'Administração', 'uri' => '/administracao/'],
                ['text' => 'Registros', 'active' => true]
            ]
        ];
        Viewer::path(SYSTEM['basepath'].'app/views/')->render('index', array_merge($data, $_SESSION['view']['data']));
    }

    public function viewUserMenu()
    {
        $data = [
            'page' => '/admin/user',
            'title' => 'Usuários',
            'breadcrumb' => [
                ['text' => 'Administração', 'uri' => '/administracao/'],
                ['text' => 'Usuários', 'active' => true]
            ]
        ];
        Viewer::path(SYSTEM['basepath'].'app/views/')->render('index', array_merge($data, $_SESSION['view']['data']));
    }

    public function updateUser()
    {
        $user = $this->entity->find($_POST['edit_id'])->execute()->toEntity();

        if(null === $user){
            throw new Exception('Usuário não encontrado');
        }

        if($user->type == 1 && (unserialize($_SESSION['user']))->id != 1){
            throw new Exception('Usuário é um administrador<br>Atualização não permitida');
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
            'script' => 'setTimeout(function(){ window.location.href="/administracao/usuarios/registros"; },2000);'
        ]);
    }

    public function view_dashboard()
    {
        $data = [
            'title' => 'Painel de controle',
            'page' => '../admin/dashboard/dashboard',
            'pageID' => 3
        ];
        Viewer::path(SYSTEM['basepath'].'app/views/admin/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function viewRecords($req, $entity)
    {
        switch($entity)
        {
            case 'usuario':
                echo json_encode($this->getListUser());
                break;
            default:
                throw new Exception('Consulta de listagem incorreta.');
                break;
        }
    }

    public function viewNewEntity($entity)
    {
        $data = [
            'page' => '/admin/dashboard',
            'title' => 'Novo registro',
            'breadcrumb' => [
                ['text' => 'Administração', 'uri' => '/administracao/']
            ]
        ];

        switch($entity)
        {
            case 'usuario':
                $data = [
                    'page' => '/user/register.form',
                    'title' => 'Novo usuário',
                    'breadcrumb' => [
                        ['text' => 'Administração', 'uri' => '/administracao/'],
                        ['text' => 'Usuários', 'uri' => '/administracao/usuarios'],
                        ['text' => 'Novo usuário', 'active' => true]
                    ]
                ];
                break;
            default:
                throw new Exception('Registro para persistência inválido', 404);
                break;
        }
        Viewer::path(SYSTEM['basepath'].'app/views/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function getListUser()
    {
        $users = $this->entity->find()->except(['password','code'])->where([
            ['id','<>', 1]
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
        return $return;
    }

    public function registerUser()
    {
        (new User_Controller())->adminRegister(Util::getData()['POST']); 
    }

    public function status_user($role, $dataselect)
    {
        $selects = $_POST;

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

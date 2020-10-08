<?php

namespace App\Controller;

use HnrAzevedo\Viewer\Viewer;
use App\Controller\User as UserController;
use App\Controller\Car as CarController;
use App\Controller\Visitant as VisitantController;
use App\Controller\Visit as VisitController;
use App\Model\User as Model;
use Exception;

class Admin extends Controller{

    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }
    private function view($data): void
    {
        Viewer::path(SYSTEM['basepath'].'app/views/')->render('index', array_merge($data, $_SESSION['view']['data']));
    }

    public function viewDashboard()
    {
        $this->view([
            'page' => '/admin/dashboard',
            'title' => 'Administração',
            'breadcrumb' => [
                ['text' => 'Administração', 'active' => true]
            ]
        ]);
    }

    public function viewRegisters()
    {
        $this->view([
            'page' => '/admin/registers',
            'title' => 'Registros',
            'breadcrumb' => [
                ['text' => 'Administração', 'uri' => '/administracao/'],
                ['text' => 'Registros', 'active' => true]
            ]
        ]);
    }

    public function viewUserMenu()
    {
        $this->view([
            'page' => '/admin/user',
            'title' => 'Usuários',
            'breadcrumb' => [
                ['text' => 'Administração', 'uri' => '/administracao/'],
                ['text' => 'Usuários', 'active' => true]
            ]
        ]);
    }

    public function viewRegisterList($entity)
    {
        switch($entity)
        {
            case 'usuarios':
                $this->view((new UserController())->grid());
            break;
            case 'veiculos':
                $this->view((new CarController())->grid());
            break;
            case 'visitantes':
                $this->view((new VisitantController())->grid());
            break;
            case 'visitas':
                $this->view((new VisitController())->grid());
            break;
            default:
                throw new \Exception('Página não encontrada', 404);
            break;
        }
    }

    public function viewRecords($req, $entity)
    {
        switch($entity)
        {
            case 'usuario':
                echo json_encode((new UserController())->list());
                break;
            case 'veiculos':
                echo json_encode((new CarController())->list());
                break;
            case 'visitantes':
                echo json_encode((new VisitantController())->list());
                break;
            case 'visitas':
                echo json_encode((new VisitController())->list());
                break;
            default:
                throw new Exception('Consulta de listagem incorreta.');
                break;
        }
    }

    public function viewDetailsEntity( $entity, $id)
    {
        switch($entity)
        {
            case 'usuarios':
                $this->view((new UserController())->details($id));
                break;
            case 'veiculos':
                $this->view((new CarController())->details($id));
                break;
            case 'visitantes':
                $this->view((new VisitantController())->details($id));
                break;
            case 'visitas':
                $this->view((new VisitController())->details($id));
                break;
            default:
                throw new Exception('Consulta de listagem incorreta.');
                break;
        }
    } 

    public function viewRegisterEntity($entity)
    {
        switch($entity)
        {
            case 'veiculos':
                $this->view([
                    'page' => '/admin/registersMenu',
                    'title' => 'Veículos',
                    'addable' => [
                        'text' => 'Novo veículo',
                        'uri' => 'administracao/novo/veiculo'
                    ],
                    'entity' => 'veiculos',
                    'breadcrumb' => [
                        ['text' => 'Administração', 'uri' => '/administracao/'],
                        ['text' => 'Registros', 'uri' => '/administracao/registros'],
                        ['text' => 'Veículos', 'active' => true]
                    ]
                ]);
                break;
            case 'visitantes':
                $this->view([
                    'page' => '/admin/registersMenu',
                    'title' => 'Visitantes',
                    'addable' => [
                        'text' => 'Novo visitante',
                        'uri' => 'administracao/novo/visitante'
                    ],
                    'entity' => 'visitantes',
                    'breadcrumb' => [
                        ['text' => 'Administração', 'uri' => '/administracao/'],
                        ['text' => 'Registros', 'uri' => '/administracao/registros'],
                        ['text' => 'Visitantes', 'active' => true]
                    ]
                ]);
                break;
            default:
                throw new Exception('Registro para persistência inválido', 404);
                break;
        }
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

    public function viewNewEntity($entity)
    {
        switch($entity)
        {
            case 'usuario':
                $this->view([
                    'page' => '/user/register.form',
                    'title' => 'Novo usuário',
                    'breadcrumb' => [
                        ['text' => 'Administração', 'uri' => '/administracao/'],
                        ['text' => 'Usuários', 'uri' => '/administracao/usuarios'],
                        ['text' => 'Novo usuário', 'active' => true]
                    ]
                ]);
                break;
            case 'veiculo':
                $this->view([
                    'page' => '/car/register.form',
                    'title' => 'Novo veículo',
                    'breadcrumb' => [
                        ['text' => 'Administração', 'uri' => '/administracao/'],
                        ['text' => 'Registros', 'uri' => '/administracao/registros'],
                        ['text' => 'Veículos', 'uri' => '/administracao/registros/veiculos'],
                        ['text' => 'Novo veículo', 'active' => true]
                    ]
                ]);
                break;
            case 'visitante':
                $this->view([
                    'page' => '/visitant/register.form',
                    'title' => 'Novo visitante',
                    'breadcrumb' => [
                        ['text' => 'Administração', 'uri' => '/administracao/'],
                        ['text' => 'Registros', 'uri' => '/administracao/registros'],
                        ['text' => 'Visitantes', 'uri' => '/administracao/registros/Visitantes'],
                        ['text' => 'Novo visitante', 'active' => true]
                    ]
                ]);
                break;
            default:
                throw new Exception('Registro para persistência inválido', 405);
                break;
        }
    }

    public function registerUser()
    {
        (new UserController())->adminRegister($_POST); 
    }

}

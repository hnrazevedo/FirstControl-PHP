<?php

namespace App\Controller;

use App\Model\Car as Model;
use App\Model\Visitant as VisitantModel;
use App\Model\Visit as VisitModel;
use App\Engine\Util;
use App\Helpers\{Converter, Mask};

class Car extends Controller
{
    use Converter, 
        Mask;

    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function viewRegister()
    {
        $this->view([
            'page' => '/car/register.form',
            'title' => 'Novo veículo',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Veículo', 'uri' => '/veiculo'],
                ['text' => 'Novo veículo', 'active' => true]
            ]
        ]);
    }

    public function viewList(): void
    {
        $this->view([
            'page' => '/admin/list',
            'title' => 'Registros de veículos',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Veículo', 'uri' => '/veiculo'],
                ['text' => 'Listagem', 'active' => true]
            ],
            'tab' => [
                'id' => 'registersCars',
                'title' => 'Registro de veículos',
                'href' => '/veiculo/',
                'uri' => '/veiculo/listagem',
                'thead' => '<th>ID</th><th>Placa</th><th>Marca</th><th>Model</th><th>Cor</th><th>Eixos</th><th>Motorista</th><th>Ações</th>'
            ]
        ]);
    }

    public function viewMenu(): void
    {
        $this->view([
            'page' => '/car/menu',
            'title' => 'Veículos',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Veículo', 'active' => true]
            ]
        ]);
    }

    public function viewDetails($id): void
    {
        $car = $this->entity->find($id)->where([
            ['id','<>',1]
        ])->execute()->toEntity();

        if(null === $car){
            throw new \Exception('Veículo não encontrado.', 404);
        }

        $lastvisit = (new VisitModel())->find()->only(['started','finished'])->where([
            'visitant','=',$car->driver
        ])->orderBy(' started DESC ')->limit(1)->execute()->toEntity();

        $lastvisit = (is_null($lastvisit)) ? ['started' => '', 'finished' => ''] : ['started' => $lastvisit->started, 'finished' => $lastvisit->finished];

        $car->driver = (new VisitantModel())->find($car->driver)->only('name')->execute()->toEntity()->name;

        $this->view([
            'page' => '/car/details',
            'title' => 'Detalhes de veículo',
            'carView' => $car,
            'lastvisit' => [ 'started' => $lastvisit['started'], 'finished' => $lastvisit['finished'] ],
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Veículo', 'uri' => '/veiculo'],
                ['text' => 'Listagem', 'uri' => '/veiculo/listagem'],
                ['text' => 'Detalhes', 'active' => true],
            ]
        ]);
    }

    public function viewEdition($id): void
    {
        $car = $this->entity->find($id)->where([
            ['id','<>',1]
        ])->execute()->toEntity();

        if(null === $car){
            throw new \Exception('Veículo não encontrado.', 404);
        }

        $cpf = (new VisitantModel())->find($car->driver)->only('cpf')->execute()->toEntity()->cpf;

        $this->view([
            'page' => '/car/edition.form',
            'title' => 'Edição de veículo',
            'carView' => $car,
            'cpf' => $this->replace('cpf', $cpf),
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Veículo', 'uri' => '/veiculo'],
                ['text' => 'Listagem', 'uri' => '/veiculo/listagem'],
                ['text' => 'Edição', 'active' => true],
            ]
        ]);
    }

    public function jsonList(): void
    {
        $cars = $this->entity->find()->where([
            ['id','<>',1]
        ])->execute()->toEntity();

        $cars = (is_array($cars)) ? $cars : [$cars];

        if(is_null($cars[0])){
            return;
        }

        $return = [];
        foreach($cars as $car => $result){
            $date = [];
            foreach($result->getData() as $field => $data){
                if($result->$field != null){
                    switch($field){
                        case 'driver':
                            $date[] = (new VisitantModel())->find($result->$field)->only('name')->execute()->toEntity()->name;
                        break;
                        case 'photo':break;
                        default:
                            $date[] = $result->$field;
                        break;
                    }
                }
            }
            $item = array_values($date);
            $item[] = "<a href='{$item[0]}/edicao'>Editar</a>";
            $return[] = $item;
        }
        echo json_encode($return);
    }

    public function register(): void
    {
        $tmpPhoto = null;

        try{

            $visitant = (new VisitantModel())->find()->only(['id','name'])->where([
                ['cpf','=',str_replace(['.','-'],'', $_POST['new_cpf'])]
            ])->execute()->toEntity();
    
            if(is_null($visitant)){
                throw new \Exception('Motorista não cadastrado');
            }
    
            $this->persistEntity(array_merge($_POST, [ 'new_visitant' => $visitant->id ]));

            if(strlen($_POST['new_carphoto']) > 0){
                $file = $this->replaceBase64($_POST['new_carphoto']);
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'car'.DIRECTORY_SEPARATOR.$_POST['new_board'].'.'.$file['ext'];
                if(file_put_contents($tmpPhoto, $file['data'])){
                    $this->entity->photo = $_POST['new_board'].'.'.$file['ext'];
                    $this->entity->save();
                }
            }

            echo json_encode([
                'success' => [
                    'message' => 'Veículo registrado com sucesso!'
                ],
                'reset' => true,
                'script' => "setTimeout(function(){ window.location.href='/veiculo'; },2000);"
            ]);

        }catch(\Exception $er){
            Util::delete($tmpPhoto);
            throw $er;
        }
        
    }

    public function edition(): void
    {
        $car = $this->entity->find($_POST['edit_id'])->execute()->toEntity();

        if(null === $car){
            throw new \Exception('Veículo não encontrado');
        }
        $visitant = (new VisitantModel())->find()->only(['id','name'])->where([
            ['cpf','=',str_replace(['.','-'],'', $_POST['edit_cpf'])]
        ])->execute()->toEntity();
    
        if(is_null($visitant)){
            throw new \Exception('Motorista não cadastrado');
        }
    
        $oldPhoto = $car->photo;

        $car->driver = $visitant->id;
        $car->board = $_POST['edit_board'];
        $car->brand = $_POST['edit_brand'];
        $car->model = $_POST['edit_model'];
        $car->color = $_POST['edit_color'];
        $car->axes = $_POST['edit_axes'];
        
        if(strlen($_POST['edit_carphoto']) > 0){
            $file = $this->replaceBase64($_POST['edit_carphoto']);
            $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'car'.DIRECTORY_SEPARATOR.$_POST['edit_board'].'.'.$file['ext'];
            if(file_put_contents($tmpPhoto, $file['data'])){
                $car->photo = $_POST['edit_board'].'.'.$file['ext'];
            }
        }

        $car->save();

        if($oldPhoto !== $car->photo){
            Util::delete(SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'car'.DIRECTORY_SEPARATOR.$oldPhoto);
        }

        echo json_encode([
            'success' => [
                'message' => 'Veículo editado com sucesso!'
            ],
            'reset' => true,
            'script' => "setTimeout(function(){ window.location.href='/veiculo'; },2000);"
        ]);        
    }

    public function checkNewRegister(array $data, int $visitantID): array
    {
        $tmpPhoto = '';
        $car = $this->entity->find()->where([
            'board','=',$data['new_board']
        ])->execute()->toEntity();

        if(is_null($car)){
            $car = $this->persistEntity(array_merge($data,[ 'new_visitant' => $visitantID ]));

            if(strlen($data['new_carphoto']) > 0){
                $file = $this->replaceBase64($data['new_carphoto']);
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'car'.DIRECTORY_SEPARATOR.$data['new_board'].'.'.$file['ext'];
                if(file_put_contents($tmpPhoto,$file['data'])){
                    $car->photo = $data['new_board'].'.'.$file['ext'];
                    $car->save();
                }
            }
        }

        return ['car' => $car, 'tmpPhoto' => $tmpPhoto];
    }

    public function persistEntity(array $data): Model
    {
        $this->entity->board = $data['new_board'];
        $this->entity->brand = $data['new_brand'];
        $this->entity->model = $data['new_model'];
        $this->entity->color = $data['new_color'];
        $this->entity->axes = $data['new_axes'];
        $this->entity->driver = $data['new_visitant'];
        $this->entity->photo = 'default.svg';

        $this->entity->persist();

        return $this->entity;
    }

    public function toJson($req, $board): void
    {
        $car = $this->entity->find()->where([
            'board','=',$board
        ])->execute()->toEntity();
        
        if(is_null($car)){
            return;
        }

        echo $car->toJson();
    }

}

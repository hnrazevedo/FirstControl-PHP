<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Model\Car as Model;
use App\Model\Visitant as Visitant;
use App\Model\Visit as Visit;
use App\Engine\Util;
use Exception;


class Car extends Controller{

    private ?Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function viewPage()
    {
        $data = [
            'title' => 'Veículos'
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/car/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function listCars()
    {
        $cars = $this->entity->find()->execute()->toEntity();

        $cars = (is_array($cars)) ? $cars : [$cars];

        if(is_null($cars[0])){
            return false;
        }

        $return = [];
        foreach($cars as $car => $result){
            $date = [];
            foreach($result->getData() as $field => $data){
                
                if($result->$field != null){
                    switch($field){
                        case 'driver':
                            $date[] = (new Visitant())->find($result->$field)->only('name')->execute()->toEntity()->name;
                        break;
                        default:
                            $date[] = $result->$field;
                        break;
                    }
                }
            }
            $return[] = array_values($date);
        }

        echo json_encode($return);
    }

    public function carRegister()
    {
        $data = json_decode(Util::getData()['POST']['data'],true);
        
        $visitant = (new Visitant())->find()->only(['id','name'])->where([
            'cpf','=',str_replace(['.','-'],'',$data['new_cpf'])
        ])->execute()->toEntity();

        if(is_null($visitant)){
            throw new Exception('Driver not found.');
        }

        $this->entity->board = $data['new_board'];
        $this->entity->brand = $data['new_brand'];
        $this->entity->model = $data['new_model'];
        $this->entity->color = $data['new_color'];
        $this->entity->axes = $data['new_axes'];
        $this->entity->driver = $visitant->id;

        $this->entity->persist();

        echo json_encode([
            'success' => [
                'message' => 'Veículo registrado com sucesso!'
            ],
            'reset' => true,
            'script' => "window.DataTables.dataAdd('table_list_cars', ['{$this->entity->id}','{$this->entity->board}','{$this->entity->brand}','{$this->entity->model}','{$this->entity->color}','{$this->entity->axes}','{$visitant->name}']);"
        ]);
    }

    public function viewDetails($id)
    {
        $car = $this->entity->find($id)->execute()->toEntity();
        
        if(is_null($car)){
            throw new Exception('Car not found.', 404);
        }

        $visit = new Visit();

        $lastvisit = $visit->find()->only(['started','finished'])->where([
            'visitant','=',$car->driver
        ])->orderBy(' started DESC ')
        ->limit(1)->execute()->toEntity();

        $car->driver = (new Visitant())->find($car->driver)->only('name')->execute()->toEntity()->name;

        $data = [
            'title' => 'Registros de Veículos',
            'pageID' => 4,
            'car' => $car,
            'lastvisit' => [ 'started' => $lastvisit->started, 'finished' => $lastvisit->finished ]
        ];
        
        Viewer::create(SYSTEM['basepath'].'app/views/car/')->render('details',array_merge($data, $_SESSION['view']['data']));
    }

    public function toJson($board)
    {
        $car = $this->entity->find()->where([
            'board','=',$board
        ])->execute()->toEntity();
        
        if(is_null($car)){
            throw new Exception('Car not found.',404);
        }

        echo $car->toJson();
    }

}

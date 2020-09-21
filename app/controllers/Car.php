<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Model\Car as Model;
use App\Model\Visitant as VisitantModel;
use App\Model\Visit as VisitModel;
use App\Engine\Util;
use Exception;

class Car extends Controller{

    private Model $entity;

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
        $cars = $this->entity->find()->where([
            ['id','<>',1]
        ])->execute()->toEntity();

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
                            $date[] = (new VisitantModel())->find($result->$field)->only('name')->execute()->toEntity()->name;
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
        $files = Util::getData()['FILES'];
        $tmpPhoto = null;

        try{

            $visitant = (new VisitantModel())->find()->only(['id','name'])->where([
                'cpf','=',str_replace(['.','-'],'',$data['new_cpf'])
            ])->execute()->toEntity();
    
            if(is_null($visitant)){
                throw new Exception('Driver not found.');
            }
    
            $this->persistEntity(array_merge($data,[ 'new_visitant' => $visitant->id ]));

            $photo = 'default.svg';

            if($files['new_carphoto']['error'] === 0){
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'car'.DIRECTORY_SEPARATOR.$data['new_board'].'.'.pathinfo($files['new_carphoto']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($files['new_carphoto']['tmp_name'],$tmpPhoto);
                $photo = $data['new_board'].'.'.pathinfo($files['new_carphoto']['name'], PATHINFO_EXTENSION);
            }

            $this->entity->photo = $photo;

            $this->entity->save();

    
            echo json_encode([
                'success' => [
                    'message' => 'Veículo registrado com sucesso!'
                ],
                'reset' => true,
                'script' => "window.DataTables.dataAdd('table_list_cars', ['{$this->entity->id}','{$this->entity->board}','{$this->entity->brand}','{$this->entity->model}','{$this->entity->color}','{$this->entity->axes}','{$visitant->name}']);"
            ]);

        }catch(Exception $er){
            Util::delete($tmpPhoto);
            throw $er;
        }
        
    }

    public function checkNewRegister(array $data, array $files, int $visitantID): array
    {
        $tmpPhoto = '';
        $car = $this->entity->find()->where([
            'board','=',$data['new_board']
        ])->execute()->toEntity();

        if(is_null($car)){
            $car = $this->persistEntity(array_merge($data,[ 'new_visitant' => $visitantID ]));

            $photo = 'default.svg';

            if($files['new_carphoto']['error'] === 0){
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'car'.DIRECTORY_SEPARATOR.$data['new_board'].'.'.pathinfo($files['new_carphoto']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($files['new_carphoto']['tmp_name'],$tmpPhoto);
                $photo = $data['new_board'].'.'.pathinfo($files['new_carphoto']['name'], PATHINFO_EXTENSION);
            }

            $car->photo = $photo;

            $car->save();
        }

        return ['visitant' => $car, 'tmpPhoto' => $tmpPhoto];
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

    public function viewDetails($id)
    {
        $car = $this->entity->find($id)->where([
            ['id','<>',1]
        ])->execute()->toEntity();
        
        if(is_null($car)){
            throw new Exception('Car not found.', 404);
        }

        $visit = new VisitModel();

        $lastvisit = $visit->find()->only(['started','finished'])->where([
            'visitant','=',$car->driver
        ])->orderBy(' started DESC ')
        ->limit(1)->execute()->toEntity();

        $car->driver = (new VisitantModel())->find($car->driver)->only('name')->execute()->toEntity()->name;

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

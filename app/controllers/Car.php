<?php

namespace App\Controller;

use App\Model\Car as Model;
use App\Model\Visitant as VisitantModel;
use App\Engine\Util;
use App\Controller\Helper\{CarChecker, CarViewer};
use App\Helpers\{Converter, Mask};

class Car extends Controller
{
    use Converter, 
        Mask,
        CarChecker,
        CarViewer;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function jsonList(): void
    {
        $cars = $this->entity->find()->except(['photo'])->where([
            ['id','<>',1]
        ])->execute()->toEntity();

        $cars = (is_array($cars)) ? $cars : [$cars];

        $this->checkCar($cars[0]);

        $return = [];
        foreach($cars as $car => $result){
            $item = array_values($this->mountItem($result));
            $item[] = "<a href='{$item[0]}/edicao'>Editar</a>";
            $return[] = $item;
        }
        echo json_encode($return);
    }

    private function mountItem($result): array
    {
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
        return $date;
    }

    public function register(): void
    {
        $tmpPhoto = null;

        try{

            $visitant = (new VisitantModel())->find()->only(['id','name'])->where([
                ['cpf','=',str_replace(['.','-'],'', $_POST['new_cpf'])]
            ])->execute()->toEntity();
    
            $this->checkDriver($visitant);
    
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

        $this->checkCar($car);

        $visitant = (new VisitantModel())->find()->only(['id','name'])->where([
            ['cpf','=',str_replace(['.','-'],'', $_POST['edit_cpf'])]
        ])->execute()->toEntity();
    
        $this->checkDriver($visitant);
    
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

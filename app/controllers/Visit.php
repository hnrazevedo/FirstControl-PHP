<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Model\Visit as Model;
use App\Model\Visitant as Visitant;
use App\Model\Car as Car;
use App\Helpers\Mask;
use App\Engine\Util;
use App\Controller\Car as CarController;
use App\Controller\Visitant as VisitantController;
use Exception;

class Visit extends Controller{
    use Mask;

    private ?Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function viewPage()
    {
        $data = [
            'title' => 'Visitas'
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/visits/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function visitRegister()
    {
        $data = json_decode(Util::getData()['POST']['data'],true);
        $files = Util::getData()['FILES'];

        $visitantController = new VisitantController();
        $carController = new CarController();
        
        $tmpPhoto = null;
        try{

            $visitant = (new Visitant())->find()->where([
                'cpf','=',str_replace(['.','-'],'',$data['new_cpf'])
            ])->execute()->toEntity();

            if(is_null($visitant)){
                $visitant = $visitantController->persistEntity($data);

                $photo = $visitant->cpf;

                if($files['new_photo']['error'] === 0){
                    $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'visitant'.DIRECTORY_SEPARATOR.$photo.'.'.pathinfo($files['new_photo']['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($files['new_photo']['tmp_name'],$tmpPhoto);
                    $photo .= '.'.pathinfo($files['new_photo']['name'], PATHINFO_EXTENSION);
                }
    
                $visitant->photo = $photo;
    
                $visitant->save();
            }

            $car = (new Car())->find()->where([
                'board','=',$data['new_board']
            ])->execute()->toEntity();

            if(is_null($car)){
                $car = $carController->persistEntity(array_merge($data,[ 'new_visitant' => $visitant->id ]));
            }

            $this->entity->visitant = $visitant->id;
            $this->entity->started = date('Y-m-d H:i:s');
            $this->entity->finished = '0000-00-00 00:00:00';
            $this->entity->reason = $data['new_reason'];
            $this->entity->responsible = $data['new_responsible'];

            $this->entity->persist();

            echo json_encode([
                'success' => [
                    'message' => 'Visita registrado com sucesso!'
                ],
                'reset' => true,
                'script' => "window.DataTables.dataAdd('table_list_visits', ['{$this->entity->id}','{$visitant->name}','{$this->replaceCPF($visitant->cpf)}','{$this->entity->started}','{$this->entity->finished}','{$this->entity->reason}','{$this->entity->responsible}','{$car->board}']);"
            ]);

            
        }catch(Exception $er){
            
            @unlink($tmpPhoto);

            throw $er;
          
        }
    }

    public function listVisits()
    {
        $visits = $this->entity->find()->execute()->toEntity();

        $visits = (is_array($visits)) ? $visits : [$visits];

        if(is_null($visits[0])){
            return false;
        }

        $return = [];
        foreach($visits as $visit => $result){
            $visitant = (new Visitant())->find($result->visitant)->only(['name','cpf'])->execute()->toEntity();
            $date = [
                $result->id,
                $visitant->name,
                $this->replaceCPF($visitant->cpf),
                $result->started,
                $result->finished,
                $result->reason,
                $result->responsible,
                'PLACA'
            ];
            
            $return[] = array_values($date);
        }

        echo json_encode($return);
    }

    public function viewDetails($id)
    {
        $visit = $this->entity->find($id)->execute()->toEntity();
        
        if(is_null($visit)){
            throw new Exception('Visit not found.', 404);
        }

        $data = [
            'title' => 'Registros de visita',
            'pageID' => 4,
            'visit' => $visit
        ];
        
        Viewer::create(SYSTEM['basepath'].'app/views/visit/')->render('details',array_merge($data, $_SESSION['view']['data']));
    }

}

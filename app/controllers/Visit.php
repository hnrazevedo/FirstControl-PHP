<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Model\Visit as Model;
use App\Model\Visitant as Visitant;
use App\Helpers\Mask;
use App\Engine\Util;
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

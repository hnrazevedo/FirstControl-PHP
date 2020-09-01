<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Model\Visitant as Model;
use Exception;


class Visitant extends Controller{

    private ?Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function view_visitants()
    {
        $data = [
            'title' => 'Visitantes'
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/visits/')->render('index' ,array_merge($data, $_SESSION['view']['data']));
    }

    public function list_visitants()
    {
        $visitants = $this->entity->find()->execute()->toEntity();

        $visitants = (is_array($visitants)) ? $visitants : [$visitants];

        if(is_null($visitants[0])){
            return false;
        }

        $return = [];
        foreach($visitants as $visitant => $result){
            $date = [];
            foreach($result->getData() as $field => $data){
                
                if($result->$field != null){
                    $date[] = $result->$field;
                }

            }
            $return[] = array_values($date);
        }

        echo json_decode($result);
    }
}
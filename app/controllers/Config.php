<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Model\Car as Model;
use App\Engine\Util;
use Exception;

class Config extends Controller{

    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function viewPage()
    {
        $data = [
            'title' => 'Configurações'
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/config/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function listConfig()
    {
        $configs = $this->entity->find()->execute()->toEntity();

        $configs = (is_array($configs)) ? $configs : [$configs];

        if(is_null($configs[0])){
            return false;
        }

        $return = [];
        foreach($configs as $config => $result){
            $date = [];
            foreach($result->getData() as $field => $data){
                $date[] = $result->$field;    
            }
            $return[] = array_values($date);
        }

        echo json_encode($return);
    }

}

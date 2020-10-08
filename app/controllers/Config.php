<?php

namespace App\Controller;

use HnrAzevedo\Viewer\Viewer;
use App\Model\Config as Model;
use Exception;

class Config extends Controller{

    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function viewList()
    {
        $data = [
            'configs' => $this->listConfig(),
            'page' => '/config/list',
            'title' => 'Configurações',
            'breadcrumb' => [
                ['text' => 'Administração', 'uri' => '/administracao/'],
                ['text' => 'Configurações', 'active' => true]
            ]
        ];
        Viewer::path(SYSTEM['basepath'].'app/views/')->render('index',array_merge($data, $_SESSION['view']['data']));
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

        return $return;
    }


    public function update($requestMethod, $id, $value)
    {
        $config = $this->entity->find((int) $id)->execute()->toEntity();
        
        if(empty(($config))){
            throw new Exception('Config not found');
        }

        $config->value = $value;
        $config->save();
        
        echo json_encode([
            'success' => [
                'message' => 'Atualizado com sucesso!'
            ]
        ]);
    }

}

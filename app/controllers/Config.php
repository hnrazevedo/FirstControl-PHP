<?php

namespace App\Controller;

use App\Model\Config as Model;

class Config extends Controller
{
    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function viewMenu(): void
    {
        $this->view([
            'page' => '/config/list',
            'title' => 'Configurações',
            'configs' => $this->list(),
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Configurações', 'active' => true]
            ]
        ]);
    }

    public function list(): array
    {
        $configs = $this->entity->find()->execute()->toEntity();

        $configs = (is_array($configs)) ? $configs : [$configs];

        if(is_null($configs[0])){
            return [];
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


    public function update($req, $id, $value): void
    {
        $config = $this->entity->find((int) $id)->execute()->toEntity();
        
        if(empty(($config))){
            throw new \Exception('Parâmetro incorreto');
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

<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Model\Visitant as Model;
use App\Engine\Util;
use Exception;


class Visitant extends Controller{

    private ?Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function viewVisitants()
    {
        $data = [
            'title' => 'Visitantes'
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/visitant/')->render('index' ,array_merge($data, $_SESSION['view']['data']));
    }

    public function listVisitants()
    {
        $visitants = $this->entity->find()->except('photo')->execute()->toEntity();

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

        echo json_encode($return);
    }

    public function visitantRegister()
    {
        $data = json_decode(Util::getData()['POST']['data'],true);
        $files = Util::getData()['FILES'];
        
        $tmpPhoto = null;
        try{
            $this->entity->name = $data['new_name'];
            $this->entity->cpf = str_replace(['.','-'],'',$data['new_cpf']);
            $this->entity->rg = str_replace(['.','-'],'',$data['new_rg']);
            $this->entity->email = $data['new_email'];
            $this->entity->birth = $data['new_birth'];
            $this->entity->phone = str_replace(['(',')',' ','-'],'',$data['new_phone']);
            $this->entity->company = $data['new_company'];
            $this->entity->register = date('Y-m-d H:i:s');
            $this->entity->lastvisit = date('Y-m-d H:i:s');
            $this->entity->photo = $this->entity->cpf;

            $this->entity->persist();

            $photo = $this->entity->cpf;

            if($files['new_photo']['error'] === 0){
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'visitant'.DIRECTORY_SEPARATOR.$photo.'.'.pathinfo($files['new_photo']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($files['new_photo']['tmp_name'],$tmpPhoto);
                $photo .= '.'.pathinfo($files['new_photo']['name'], PATHINFO_EXTENSION);
            }

            $this->entity->photo = $photo;

            $this->entity->save();

            
        }catch(Exception $er){
            
            @unlink($tmpPhoto);

            throw $er;
          
        }
       
    }

    public function viewDetails($id)
    {
        $visitant = $this->entity->find($id)->execute()->toEntity();
        
        if(is_null($visitant)){
            throw new Exception('Visitant not found.',404);
        }

        $data = [
            'title' => 'Registros de visitantes',
            'pageID' => 4,
            'visitant' => $visitant
        ];
        
        Viewer::create(SYSTEM['basepath'].'app/views/visitant/')->render('details',array_merge($data, $_SESSION['view']['data']));
    }
}
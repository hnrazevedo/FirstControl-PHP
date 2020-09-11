<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Model\Visitant as Model;
use App\Engine\Util;
use App\Helpers\Mask;
use Exception;


class Visitant extends Controller{
    use Mask;

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
                    switch($field){
                        case 'cpf':
                            $date[] = $this->replaceCPF($result->$field);
                        break;
                        case 'rg':
                            $date[] = $this->replaceRG($result->$field);
                        break;
                        case 'phone':
                            $date[] = $this->replaceCellPhone($result->$field);
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

    public function visitantRegister()
    {
        $data = json_decode(Util::getData()['POST']['data'],true);
        $files = Util::getData()['FILES'];
        
        $tmpPhoto = null;
        try{

            $this->persistEntity($data);

            $photo = $this->entity->cpf;

            if($files['new_photo']['error'] === 0){
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'visitant'.DIRECTORY_SEPARATOR.$photo.'.'.pathinfo($files['new_photo']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($files['new_photo']['tmp_name'],$tmpPhoto);
                $photo .= '.'.pathinfo($files['new_photo']['name'], PATHINFO_EXTENSION);
            }

            $this->entity->photo = $photo;

            $this->entity->save();

            echo json_encode([
                'success' => [
                    'message' => 'Visitante registrado com sucesso!'
                ],
                'reset' => true,
                'script' => "window.DataTables.dataAdd('table_list_visitants', ['{$this->entity->id}','{$this->entity->name}','{$this->replaceCPF($this->entity->cpf)}','{$this->replaceRG($this->entity->rg)}','{$this->entity->birth}','{$this->entity->lastvisit}','{$this->entity->register}','{$this->entity->company}','{$this->replaceCellPhone($this->entity->phone)}','{$this->entity->email}']);"
            ]);

            
        }catch(Exception $er){
            
            @unlink($tmpPhoto);

            throw $er;
          
        }
       
    }

    public function persistEntity(array $data): Model
    {
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

        return $this->entity;
    }

    public function viewDetails($id)
    {
        $visitant = $this->entity->find($id)->execute()->toEntity();
        
        if(is_null($visitant)){
            throw new Exception('Visitant not found.',404);
        }

        $visitant->cpf = $this->replaceCPF($visitant->cpf);
        $visitant->rg = $this->replaceRG($visitant->rg);
        $visitant->phone = $this->replaceCellPhone($visitant->phone);

        $data = [
            'title' => 'Registros de visitantes',
            'pageID' => 4,
            'visitant' => $visitant
        ];
        
        Viewer::create(SYSTEM['basepath'].'app/views/visitant/')->render('details',array_merge($data, $_SESSION['view']['data']));
    }

    public function toJson($cpf)
    {
        $visitant = $this->entity->find()->where([
            'cpf','=',str_replace(['.','-'],'',$cpf)
        ])->execute()->toEntity();

        
        if(is_null($visitant)){
            throw new Exception('Visitant not found.',404);
        }

        $visitant->cpf = $this->replaceCPF($visitant->cpf);
        $visitant->rg = $this->replaceRG($visitant->rg);
        $visitant->phone = $this->replaceCellPhone($visitant->phone);

        echo $visitant->toJson();
    }
}
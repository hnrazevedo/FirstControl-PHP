<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Model\Visitant as Model;
use App\Engine\Util;
use App\Helpers\{Mask , Validate};
use Exception;


class Visitant extends Controller{
    use Mask, Validate;

    private Model $entity;

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
        $visitants = $this->entity->find()->where([
            ['id','<>',1]
        ])->except('photo')->execute()->toEntity();

        $visitants = (is_array($visitants)) ? $visitants : [$visitants];

        if(is_null($visitants[0])){
            return false;
        }

        $return = [];
        foreach($visitants as $visitant => $result){
            $date = [];
            foreach($result->getData() as $field => $data){
                
                if($result->$field != null){
                    $date[] = $this->replace($field,$result->$field);
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

            if(!$this->isValidCPF($data['new_cpf'])){
                throw new Exception('CPF invalid.');
            }

            $this->persistEntity($data);

            $photo = 'default.svg';

            if($files['new_photo']['error'] === 0){
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'visitant'.DIRECTORY_SEPARATOR.str_replace(['.','-'],'',$data['new_cpf']).'.'.pathinfo($files['new_photo']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($files['new_photo']['tmp_name'],$tmpPhoto);
                $photo = str_replace(['.','-'],'',$data['new_cpf']).'.'.pathinfo($files['new_photo']['name'], PATHINFO_EXTENSION);
            }

            $this->entity->photo = $photo;

            $this->entity->save();

            echo json_encode([
                'success' => [
                    'message' => 'Visitante registrado com sucesso!'
                ],
                'reset' => true,
                'script' => "DataTables.dataAdd('table_list_visitants', ['{$this->entity->id}','{$this->entity->name}','{$this->replaceCPF($this->entity->cpf)}','{$this->replaceRG($this->entity->rg)}','{$this->entity->birth}','{$this->entity->lastvisit}','{$this->entity->register}','{$this->entity->company}','{$this->replaceCellPhone($this->entity->phone)}','{$this->entity->email}']);"
            ]);
   
        }catch(Exception $er){
            Util::delete($tmpPhoto);
            throw $er;
        }
    }

    public function checkNewRegister(array $data, array $files): array
    {
        $tmpPhoto = '';
        $visitant = $this->entity->find()->where([
            'cpf','=',str_replace(['.','-'],'',$data['new_cpf'])
        ])->execute()->toEntity();

        if(is_null($visitant)){
            $visitant = $this->persistEntity($data);

            $photo = 'default.svg';

            if($files['new_photo']['error'] === 0){
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'visitant'.DIRECTORY_SEPARATOR.str_replace(['.','-'],'',$data['new_cpf']).'.'.pathinfo($files['new_photo']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($files['new_photo']['tmp_name'],$tmpPhoto);
                $photo = str_replace(['.','-'],'',$data['new_cpf']).'.'.pathinfo($files['new_photo']['name'], PATHINFO_EXTENSION);
            }

            $visitant->photo = $photo;

            $visitant->save();
        }
        
        return ['visitant' => $visitant, 'tmpPhoto' => $tmpPhoto];
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
        $this->entity->photo = 'default.svg';

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
<?php

namespace App\Controller;

use App\Controller\Helper\VisitantChecker;
use App\Controller\Helper\VisitantViewer;
use App\Model\Visitant as Model;
use App\Engine\Util;
use App\Helpers\{Converter, Mask , Validate};

class Visitant extends Controller
{
    use Mask,
        Validate,
        Converter,
        VisitantChecker,
        VisitantViewer;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function jsonList(): void
    {
        $visitants = $this->entity->find()->only(['id','name','cpf','rg','company','phone','lastvisit'])->where([
            ['id','<>',1]
        ])->except('photo')->execute()->toEntity();

        $visitants = $this->getArray($visitants);

        $this->throwVisitant($visitants[0]);

        $return = [];
        foreach($visitants as $visitant => $result){
            $date = [];
            foreach($result->getData() as $field => $data){
                if($result->$field != null){
                    $date[] = $this->replace($field, $result->$field);
                }
            }
            $item = array_values($date);
            $item[] = "<a href='{$item[0]}/edicao'>Editar</a>";
            $return[] = $item;
        }

        echo json_encode($return);
    }

    public function register(): void
    {
        $tmpPhoto = null;
        try{

            $this->throwCPF($_POST['new_cpf']);

            $this->persistEntity($_POST);

            if(strlen($_POST['new_photo']) > 0){
                $file = $this->replaceBase64($_POST['new_photo']);
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'visitant'.DIRECTORY_SEPARATOR.str_replace([',','.','-'],'', $_POST['new_cpf']).'.'.$file['ext'];
                if(file_put_contents($tmpPhoto, $file['data'])){
                    $this->entity->photo = str_replace([',','.','-'],'', $_POST['new_cpf']).'.'.$file['ext'];
                    $this->entity->save();
                }
            }

            echo json_encode([
                'success' => [
                    'message' => 'Visitante registrado com sucesso!'
                ],
                'reset' => true,
                'script' => 'setTimeout(function(){ window.location.href="/visitante"; },2000);'
            ]);
   
        }catch(\Exception $er){
            Util::delete($tmpPhoto);
            throw $er;
        }
    }

    public function edition(): void
    {
        $this->throwCpf($_POST['edit_cpf']);

        $visitant = $this->entity->find($_POST['edit_id'])->execute()->toEntity();

        $this->throwVisitant($visitant);

        $oldPhoto = $visitant->photo;
        $visitant->name = $_POST['edit_name'];
        $visitant->email = $_POST['edit_email'];
        $visitant->cpf = str_replace(['.','-'], '', $_POST['edit_cpf']);
        $visitant->rg = str_replace(['.','-'], '', $_POST['edit_rg']);
        $visitant->transport = $_POST['edit_transport'];
        $visitant->phone = str_replace(['(',')',' ','-'],'',$_POST['edit_phone']);
        $visitant->company = $_POST['edit_company'];

        if(strlen($_POST['edit_photo']) > 0){
            $file = $this->replaceBase64($_POST['edit_photo']);
            $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'visitant'.DIRECTORY_SEPARATOR.str_replace([',','.','-'],'', $_POST['edit_cpf']).'.'.$file['ext'];
            if(file_put_contents($tmpPhoto, $file['data'])){
                $visitant->photo = str_replace([',','.','-'],'', $_POST['edit_cpf']).'.'.$file['ext'];
            }
        }

        $visitant->save();

        if($oldPhoto !== $visitant->photo){
            Util::delete(SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'visitant'.DIRECTORY_SEPARATOR.$oldPhoto);
        }

        echo json_encode([
            'success' => [
                'message' => 'Visitante editado com sucesso!'
            ],
            'reset' => true,
            'script' => 'setTimeout(function(){ window.location.href="/visitante"; },2000);'
        ]);
    }

    public function checkNewRegister(array $data): array
    {
        $tmpPhoto = '';
        $visitant = $this->entity->find()->where([
            'cpf','=',str_replace(['.','-'],'',$data['new_cpf'])
        ])->execute()->toEntity();

        if(is_null($visitant)){
            $visitant = $this->persistEntity($data);

            if(strlen($data['new_photo']) > 0){
                $file = $this->replaceBase64($data['new_photo']);
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'visitant'.DIRECTORY_SEPARATOR.str_replace([',','.','-'],'',$data['new_cpf']).'.'.$file['ext'];
                if(file_put_contents($tmpPhoto,$file['data'])){
                    $visitant->photo = str_replace([',','.','-'],'',$data['new_cpf']).'.'.$file['ext'];
                    $visitant->save();
                }
            }
        }
        
        return ['visitant' => $visitant, 'tmpPhoto' => $tmpPhoto];
    }

    public function persistEntity(array $data): Model
    {
        $this->entity->name = $data['new_name'];
        $this->entity->cpf = str_replace(['.','-'],'',$data['new_cpf']);
        $this->entity->rg = str_replace(['.','-'],'',$data['new_rg']);
        $this->entity->email = $data['new_email'];
        $this->entity->transport = $data['new_transport'];
        $this->entity->phone = str_replace(['(',')',' ','-'],'',$data['new_phone']);
        $this->entity->company = $data['new_company'];
        $this->entity->register = date('Y-m-d H:i:s');
        $this->entity->lastvisit = date('Y-m-d H:i:s');
        $this->entity->photo = 'default.svg';
        $this->entity->persist();
        return $this->entity;
    }

    public function toJson(/** @scrutinizer ignore-unused */ $req, $cpf): void
    {
        $visitant = $this->entity->find()->where([
            'cpf','=',str_replace(['.','-'],'',$cpf)
        ])->execute()->toEntity();

        $this->throwVisitant($visitant);

        $visitant->cpf = $this->replaceCPF($visitant->cpf);
        $visitant->rg = $this->replaceRG($visitant->rg);
        $visitant->phone = $this->replaceCellPhone($visitant->phone);

        echo $visitant->toJson();
    }
}

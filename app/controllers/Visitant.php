<?php

namespace App\Controller;

use HnrAzevedo\Viewer\Viewer;
use App\Model\Visitant as Model;
use App\Engine\Util;
use App\Helpers\{Converter, Mask , Validate};
use Exception;


class Visitant extends Controller{
    use Mask,
        Validate,
        Converter;

    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function grid()
    {
        return [
            'page' => '/admin/list',
            'title' => 'Registros de visitantes',
            'breadcrumb' => [
                ['text' => 'Administração', 'uri' => '/administracao/'],
                ['text' => 'Registros', 'uri' => '/administracao/registros'],
                ['text' => 'Visitantes', 'uri' => '/administracao/registros/visitantes'],
                ['text' => 'Listagem', 'active' => true]
            ],
            'tab' => [
                'id' => 'registersVisitants',
                'title' => 'Registro de usuários',
                'href' => '/administracao/visitantes/',
                'uri' => '/administracao/visitantes/listagem',
                'thead' => '<th>ID</th><th>Nome</th><th>CPF</th><th>RG</th><th>Últ. Visita</th><th>Empresa</th><th>Contato</th>'
            ]
        ];
    }

    public function list()
    {
        $visitants = $this->entity->find()->only(['id','name','cpf','rg','company','phone','lastvisit'])->where([
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

        return $return;
    }

    public function details($id)
    {
        $visitant = $this->entity->find($id)->execute()->toEntity();

        if(is_null($visitant)){
            throw new Exception('Visitante não encontrado', 404);
        }

        $visitant->cpf = $this->replaceCPF($visitant->cpf);
        $visitant->rg = $this->replaceRG($visitant->rg);
        $visitant->phone = $this->replaceCellPhone($visitant->phone);

        return [
            'page' => '/visitant/details',
            'title' => 'Detalhes de visitante',
            'visitantView' => $visitant,
            'breadcrumb' => [
                ['text' => 'Administração', 'uri' => '/administracao/'],
                ['text' => 'Registros', 'uri' => '/administracao/registros'],
                ['text' => 'Visitantes', 'uri' => '/administracao/registros/visitantes'],
                ['text' => 'Listagem', 'uri' => '/administracao/registros/visitantes/listagem'],
                ['text' => 'Detalhes', 'active' => true],
            ]
        ];
    }

    public function visitantRegister()
    {
        $data = $_POST;
        
        $tmpPhoto = null;
        try{

            if(!$this->isValidCPF($data['new_cpf'])){
                throw new Exception('CPF invalid.');
            }

            $this->persistEntity($data);

            if(strlen($data['new_photo']) > 0){
                $file = $this->replaceBase64($data['new_photo']);
                $tmpPhoto = SYSTEM['basepath'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'visitant'.DIRECTORY_SEPARATOR.str_replace([',','.','-'],'',$data['new_cpf']).'.'.$file['ext'];
                if(file_put_contents($tmpPhoto,$file['data'])){
                    $this->entity->photo = str_replace([',','.','-'],'',$data['new_cpf']).'.'.$file['ext'];
                    $this->entity->save();
                }
            }

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
        $this->entity->birth = $data['new_birth'];
        $this->entity->phone = str_replace(['(',')',' ','-'],'',$data['new_phone']);
        $this->entity->company = $data['new_company'];
        $this->entity->register = date('Y-m-d H:i:s');
        $this->entity->lastvisit = date('Y-m-d H:i:s');
        $this->entity->photo = 'default.svg';

        $this->entity->persist();

        return $this->entity;
    }

    public function toJson($req, $cpf)
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
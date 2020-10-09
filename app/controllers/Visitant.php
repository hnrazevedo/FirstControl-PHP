<?php

namespace App\Controller;

use App\Model\Visitant as Model;
use App\Engine\Util;
use App\Helpers\{Converter, Mask , Validate};

class Visitant extends Controller
{
    use Mask,
        Validate,
        Converter;

    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function viewRegister()
    {
        $this->view([
            'page' => '/visitant/register.form',
            'title' => 'Novo visitante',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Visitante', 'uri' => '/visitante'],
                ['text' => 'Novo visitante', 'active' => true]
            ]
        ]);
    }

    public function viewList(): void
    {
        $this->view([
            'page' => '/admin/list',
            'title' => 'Registros de visitantes',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Visitante', 'uri' => '/visitante'],
                ['text' => 'Listagem', 'active' => true]
            ],
            'tab' => [
                'id' => 'registersVisitants',
                'title' => 'Registro de visitantes',
                'href' => '/visitante/',
                'uri' => '/visitante/listagem',
                'thead' => '<th>ID</th><th>Nome</th><th>CPF</th><th>RG</th><th>Últ. Visita</th><th>Empresa</th><th>Contato</th>'
            ]
        ]);
    }

    public function viewMenu(): void
    {
        $this->view([
            'page' => '/visitant/menu',
            'title' => 'Visitantes',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Visitante', 'active' => true]
            ]
        ]);
    }

    public function jsonList(): void
    {
        $visitants = $this->entity->find()->only(['id','name','cpf','rg','company','phone','lastvisit'])->where([
            ['id','<>',1]
        ])->except('photo')->execute()->toEntity();

        $visitants = (is_array($visitants)) ? $visitants : [$visitants];

        if(is_null($visitants[0])){
            return;
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

    public function viewDetails($id): void
    {
        $visitant = $this->entity->find($id)->execute()->toEntity();

        if(is_null($visitant)){
            throw new \Exception('Visitante não encontrado', 404);
        }

        $visitant->cpf = $this->replaceCPF($visitant->cpf);
        $visitant->rg = $this->replaceRG($visitant->rg);
        $visitant->phone = $this->replaceCellPhone($visitant->phone);

        $this->view([
            'page' => '/visitant/details',
            'title' => 'Detalhes de visitante',
            'visitantView' => $visitant,
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Visitante', 'uri' => '/visitante'],
                ['text' => 'Listagem', 'uri' => '/visitante/listagem'],
                ['text' => 'Detalhes', 'active' => true],
            ]
        ]);
    }

    public function register(): void
    {
        $tmpPhoto = null;
        try{

            if(!$this->isValidCPF($_POST['new_cpf'])){
                throw new \Exception('CPF invalid.');
            }

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

    public function toJson($req, $cpf): void
    {
        $visitant = $this->entity->find()->where([
            'cpf','=',str_replace(['.','-'],'',$cpf)
        ])->execute()->toEntity();

        
        if(is_null($visitant)){
            throw new \Exception('Visitant not found.',404);
        }

        $visitant->cpf = $this->replaceCPF($visitant->cpf);
        $visitant->rg = $this->replaceRG($visitant->rg);
        $visitant->phone = $this->replaceCellPhone($visitant->phone);

        echo $visitant->toJson();
    }
}
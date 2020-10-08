<?php

namespace App\Controller;

use HnrAzevedo\Viewer\Viewer;
use App\Model\Visit as Model;
use App\Model\Visitant as VisitantModel;
use App\Model\Car as CarModel;
use App\Model\User as UserModel;
use App\Helpers\Mask;
use App\Engine\Util;
use App\Controller\Car as CarController;
use App\Controller\Visitant as VisitantController;
use Exception;

class Visit extends Controller{
    use Mask;

    private Model $entity;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function grid()
    {
        return [
            'page' => '/admin/list',
            'title' => 'Registros de visitas',
            'breadcrumb' => [
                ['text' => 'Administração', 'uri' => '/administracao/'],
                ['text' => 'Registros', 'uri' => '/administracao/registros'],
                ['text' => 'Visitas', 'uri' => '/administracao/registros/visitas'],
                ['text' => 'Listagem', 'active' => true]
            ],
            'tab' => [
                'id' => 'registersVisits',
                'title' => 'Registro de visitas',
                'href' => '/administracao/visitas/',
                'uri' => '/administracao/visitas/listagem',
                'thead' => '<th>ID</th><th>Visitante</th><th>CPF</th><th>Entrada</th><th>Saída</th><th>Status</th><th>Razão/Motivo</th><th>Responsável</th><th>Veículo</th>'
            ]
        ];
    }


    public function register()
    {
        $visitantController = new VisitantController();
        $carController = new CarController();
        
        $tmpPhoto = null;
        $tmpPhotoCar = null;
        try{

            $visitantRegister = $visitantController->checkNewRegister($_POST);
            $visitant = $visitantRegister['visitant'];
            $tmpPhoto = $visitantRegister['tmpPhoto'];

            $carRegister = $carController->checkNewRegister($_POST,$visitant->id);
            $car = $carRegister['car'];
            $tmpPhotoCar = $carRegister['tmpPhoto'];

            $this->entity->user = (unserialize($_SESSION['user']))->id;
            $this->entity->visitant = $visitant->id;
            $this->entity->started = date('Y-m-d H:i:s');
            $this->entity->finished = '0000-00-00 00:00:00';
            $this->entity->reason = $_POST['new_reason'];
            $this->entity->responsible = $_POST['new_responsible'];
            $this->entity->status = 0;
            $this->entity->car = $car->id;

            $this->entity->persist();

            echo json_encode([
                'success' => [
                    'message' => 'Visita registrado com sucesso!'
                ],
                'reset' => true,
                'script' => 'setTimeout(function(){ window.location.href="/administracao/registros/visitas"; },2000);'
            ]);

            
        }catch(Exception $er){
            
            Util::delete($tmpPhoto);
            Util::delete($tmpPhotoCar);

            throw $er;
          
        }
    }

    public function list()
    {
        $visits = $this->entity->find()->where([
            ['id','<>',1]
        ])->execute()->toEntity();

        $visits = (is_array($visits)) ? $visits : [$visits];

        if(is_null($visits[0])){
            return false;
        }

        $return = [];
        foreach($visits as $visit => $result){
            $visitant = (new VisitantModel())->find($result->visitant)->only(['name','cpf'])->execute()->toEntity();

            $car = (empty($result->car)) ? (new CarModel())->find($result->car)->only('board')->execute()->toEntity()->board : '-';
            
            $finished = ($result->status == 0) ? '-' : $result->finished; 
            
            $status = ($result->status == 0) ? 'Em andamento' : 'Finalizada'; 
 
            $date = [
                $result->id,
                $visitant->name,
                $this->replaceCPF($visitant->cpf),
                $result->started,
                $finished,
                $status,
                $result->reason,
                $result->responsible,
                $car
            ];
            
            $return[] = array_values($date);
        }

        return $return;
    }

    public function details($id)
    {
        $visit = $this->entity->find($id)->execute()->toEntity();
        
        if(is_null($visit)){
            throw new Exception('Visit not found.', 404);
        }

        $car = (new CarModel())->find($visit->car)->execute()->toEntity();
        $visitant = (new VisitantModel())->find($visit->visitant)->execute()->toEntity();

        $day = (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $visit->started) , 'd/m/Y'));
        $dayFinal = (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $visit->finished) , 'd/m/Y'));

        if($day !== $dayFinal && $visit->status != 0){
            $day .= ' até '.$dayFinal;
        }


        $date = [
            'day' =>  $day,
            'started' => (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $visit->started) , 'H:i:s')),
            'finished'=> (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $visit->finished) , 'H:i:s'))
        ];

        $data = [
            'title' => 'Registros de visita',
            'pageID' => 4,
            'visit' => $visit,
            'visitant' => $visitant,
            'car' => $car,
            'status' => ( $visit->status == 0 ) ? 'Em andamento' : 'Finalizada',
            'date' => $date,
            'user' => (new UserModel())->find($visit->user)->only('name')->execute()->toEntity()
        ];
        
        Viewer::path(SYSTEM['basepath'].'app/views/visits/')->render('details',array_merge($data, $_SESSION['view']['data']));
    }

}

<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;
use App\Model\Visit as Model;
use App\Model\Visitant as Visitant;
use App\Model\Car as Car;
use App\Model\User as User;
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

    public function viewPage()
    {
        $data = [
            'title' => 'Visitas'
        ];
        Viewer::create(SYSTEM['basepath'].'app/views/visits/')->render('index',array_merge($data, $_SESSION['view']['data']));
    }

    public function visitRegister()
    {
        $data = json_decode(Util::getData()['POST']['data'],true);
        $files = Util::getData()['FILES'];

        $visitantController = new VisitantController();
        $carController = new CarController();
        
        $tmpPhoto = null;
        $tmpPhotoCar = null;
        try{

            $visitantRegister = $visitantController->checkNewRegister($data,$_FILES);
            $visitant = $visitantRegister['visitant'];
            $tmpPhoto = $visitantRegister['tmpPhoto'];

            $carRegister = $carController->checkNewRegister($data,$_FILES,$visitant->id);
            $car = $carRegister['car'];
            $tmpPhotoCar = $carRegister['tmpPhoto'];

            $this->entity->user = (unserialize($_SESSION['user']))->id;
            $this->entity->visitant = $visitant->id;
            $this->entity->started = date('Y-m-d H:i:s');
            $this->entity->finished = '0000-00-00 00:00:00';
            $this->entity->reason = $data['new_reason'];
            $this->entity->responsible = $data['new_responsible'];
            $this->entity->status = 0;
            $this->entity->car = $car->id;

            $this->entity->persist();

            echo json_encode([
                'success' => [
                    'message' => 'Visita registrado com sucesso!'
                ],
                'reset' => true,
                'script' => "window.DataTables.dataAdd('table_list_visits', ['{$this->entity->id}','{$visitant->name}','{$this->replaceCPF($visitant->cpf)}','{$this->entity->started}','{$this->entity->finished}','{$this->entity->reason}','{$this->entity->responsible}','{$car->board}']);"
            ]);

            
        }catch(Exception $er){
            
            Util::delete($tmpPhoto);
            Util::delete($tmpPhotoCar);

            throw $er;
          
        }
    }

    public function listVisits()
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
            $visitant = (new Visitant())->find($result->visitant)->only(['name','cpf'])->execute()->toEntity();

            $car = (empty($result->car)) ? (new Car())->find($result->car)->only('board')->execute()->toEntity()->board : '-';
            
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

        echo json_encode($return);
    }

    public function viewDetails($id)
    {
        $visit = $this->entity->find($id)->execute()->toEntity();
        
        if(is_null($visit)){
            throw new Exception('Visit not found.', 404);
        }

        $car = (new Car())->find($visit->car)->execute()->toEntity();
        $visitant = (new Visitant())->find($visit->visitant)->execute()->toEntity();

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
            'user' => (new User())->find($visit->user)->only('name')->execute()->toEntity()
        ];
        
        Viewer::create(SYSTEM['basepath'].'app/views/visits/')->render('details',array_merge($data, $_SESSION['view']['data']));
    }

}

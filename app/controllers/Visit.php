<?php

namespace App\Controller;

use App\Model\Visit as Model;
use App\Model\Visitant as VisitantModel;
use App\Model\Car as CarModel;
use App\Model\Balance as BalanceModel;
use App\Helpers\Mask;
use App\Engine\Util;
use App\Controller\Car as CarController;
use App\Controller\Visitant as VisitantController;
use App\Controller\Balance as BalanceController;
use App\Controller\Helper\VisitViewer;

class Visit extends Controller
{
    use Mask,
        VisitViewer;

    public function __construct()
    {
        $this->entity = new Model();
    }

    public function register(): void
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
            $this->entity->balance = (new BalanceController())->register($_POST);
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
                'script' => 'setTimeout(function(){ window.location.href="/visita"; },2000);'
            ]);
        }catch(\Exception $er){
            Util::delete($tmpPhoto);
            Util::delete($tmpPhotoCar);
            throw $er;
        }
    }

    public function finish(): void
    {
        $visit = $this->entity->find(intval($_POST['upt_id']))->execute()->toEntity();

        if(null === $visit){
            throw new \Exception('Visita não encontrada');
        }

        $balance = (new BalanceModel())->find(intval($visit->balance))->execute()->toEntity();

        $balance->ending = $_POST['upt_weight'];
        $balance->save();

        $visit->status = 1;
        $visit->finished = date('Y-m-d H:i:s');
        $visit->save();

        $_SESSION['alert'] = [
            'message' => 'Visita finalizada com sucesso',
            'class' => 'success'
        ];

        echo json_encode(['script' => 'window.location.href="/visita/'.$_POST['upt_id'].'/detalhes";']);
    }

    public function jsonList(): void
    {
        $visits = $this->entity->find()->execute()->toEntity();

        $visits = $this->getArray($visits);

        if(is_null($visits[0])){
            return;
        }

        $return = [];
        foreach($visits as $visit => $result){
            $item = $this->mountItem($result);
           
            $item[] = (($item[5] !== 'Finalizada')) 
            ? "<a href='{$item[0]}/detalhes' class='btn btn-primary list' data-toggle='tooltip' title='Detalhes'><i class='bx bx-show'></i></a>
               <a href='{$item[0]}/finalizar' class='btn btn-primary list' data-toggle='tooltip' title='Finalizar'><i class='bx bx-send'></i></a>"
            : "<a href='{$item[0]}/detalhes' class='btn btn-primary list' data-toggle='tooltip' title='Detalhes'><i class='bx bx-show'></i></a>";
            
            $return[] = array_values($item);
        }

        echo json_encode($return);
    }

    private function mountItem($result): array
    {
        $visitant = (new VisitantModel())->find($result->visitant)->only(['name','cpf'])->execute()->toEntity();

        $car = (empty($result->car)) ? (new CarModel())->find($result->car)->only('board')->execute()->toEntity()->board : '-';
            
        $finished = ($result->status == 0) ? '-' : $result->finished; 
            
        $status = ($result->status == 0) ? 'Em andamento' : 'Finalizada'; 
 
        return [
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
    }

}

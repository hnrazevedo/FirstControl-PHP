<?php

namespace App\Controller\Helper;

use App\Helpers\Mask;
use App\Model\Visit as Model;
use App\Model\User as UserModel;
use App\Model\Balance as BalanceModel;
use App\Model\Car as CarModel;
use App\Model\Visitant as VisitantModel;

trait VisitViewer
{
    protected Model $entity;

    use Viewer,
        Mask,
        Printer;

    public function viewRegister(): void
    {
        $this->view([
            'page' => '/visits/register.form',
            'title' => 'Nova visita',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Visita', 'uri' => '/visita'],
                ['text' => 'Novo visita', 'active' => true]
            ]
        ]);
    }

    public function viewList(): void
    {
        $this->view([
            'page' => '/admin/list',
            'title' => 'Registros de visitas',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Visita', 'uri' => '/visita'],
                ['text' => 'Listagem', 'active' => true]
            ],
            'tab' => [
                'id' => 'registersVisits',
                'title' => 'Registro de visita',
                'href' => '/visita/',
                'uri' => '/visita/listagem',
                'thead' => '<th>ID</th><th>Visitante</th><th>CPF</th><th>Entrada</th><th>Saída</th><th>Status</th><th>Razão/Motivo</th><th>Responsável</th><th>Veículo</th><th>Ações</th>'
            ]
        ]);
    }

    public function viewMenu(): void
    {
        $this->view([
            'page' => '/visits/menu',
            'title' => 'Visitas',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Visita', 'active' => true]
            ]
        ]);
    }

    public function viewFinish(string $id): void
    {
        $visit = $this->entity->find(intval($id))->where([
            ['status', '=', 0]
        ])->execute()->toEntity();
        
        if(is_null($visit)){
            throw new \Exception('Visita não encontrada ou finalizada', 404);
        }

        $this->viewDetails($id, ['title' => 'Finalização de visita', 'page' => 'finish.form']);
    }

    public function viewPrint(string $id): void
    {
        $this->print(array_merge($this->getDetails($id),[
            'page' => '../visits/print'
        ]));
    }

    private function throwVisit($visit): void
    {
        if(null === $visit){
            throw new \Exception('Visita não encontrada ou finalizada', 404);
        }
    }

    public function viewDetails(string $id, ?array $data = null): void
    {
        $details = $this->getDetails($id);

        $this->view([
            'title' => (null !== $data) ? $data['title'] : 'Detalhes de visita',
            'page' => (null !== $data) ? "/visits/{$data['page']}" : '/visits/details',
            'visitView' => $details['visitView'],
            'visitant' => $details['visitant'],
            'car' => $details['car'],
            'balanceView' => $details['balance'],
            'status' => ( $details['visitView']->status == 0 ) ? 'Em andamento' : 'Finalizada',
            'date' => [
                'day' =>  $details['day'],
                'started' => (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $details['visitView']->started) , 'H:i:s')),
                'finished'=> (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $details['visitView']->finished) , 'H:i:s'))
            ],
            'user' => (new UserModel())->find($details['visitView']->user)->only('name')->execute()->toEntity(),
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Visita', 'uri' => '/visita'],
                ['text' => 'Listagem', 'uri' => '/visita/listagem'],
                ['text' => 'Detalhes', 'active' => true],
            ]
        ]);
        
    }

    private function getDetails(string $id): array
    {
        $visit = $this->entity->find(intval($id))->execute()->toEntity();
        
        $this->throwVisit($visit);

        $car = (new CarModel())->find($visit->car)->execute()->toEntity();
        $visitant = (new VisitantModel())->find($visit->visitant)->execute()->toEntity();

        $day = (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $visit->started) , 'd/m/Y'));
        $dayFinal = (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $visit->finished) , 'd/m/Y'));

        $balance = (new BalanceModel())->find($visit->balance)->execute()->toEntity();

        $balance = [
            'input' => number_format(floatval($balance->input), 2),
            'ending' => number_format(floatval($balance->ending), 2),
            'difference' => number_format(floatval($balance->input - $balance->ending), 2),
            'action' => (number_format(floatval($balance->input - $balance->ending), 2) < 0) ? 'Retirada de material' : 'Entrada de material'
        ];

        if($day !== $dayFinal && $visit->status != 0){
            $day .= ' até '.$dayFinal;
        }

        return [
            'visitView' => $visit,
            'car' => $car,
            'visitant' => $visitant,
            'balance' => $balance,
            'day' => $day
        ];
    }

}

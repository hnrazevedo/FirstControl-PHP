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
        Mask;

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

    public function viewFinish($id): void
    {
        $this->viewDetails($id, 'finish');
    }

    public function viewDetails(string $id, ?string $page = null): void
    {
        $visit = $this->entity->find($id)->execute()->toEntity();
        
        if(is_null($visit)){
            throw new \Exception('Visit not found.', 404);
        }

        $car = (new CarModel())->find($visit->car)->execute()->toEntity();
        $visitant = (new VisitantModel())->find($visit->visitant)->execute()->toEntity();

        $day = (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $visit->started) , 'd/m/Y'));
        $dayFinal = (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $visit->finished) , 'd/m/Y'));

        $balance = (new BalanceModel())->find($visit->balance)->execute()->toEntity();

        $balance = [
            'input' => number_format(floatval($balance->input), 2),
            'ending' => number_format(floatval($balance->ending), 2),
            'difference' => number_format(floatval($balance->input - $balance->ending), 2)
        ];

        if($day !== $dayFinal && $visit->status != 0){
            $day .= ' até '.$dayFinal;
        }

        $this->view([
            'title' => (null !== $page) ? 'Finalização de visita' : 'Detalhes de visita',
            'page' => (null !== $page) ? '/visits/finish.form' : '/visits/details',
            'visitView' => $visit,
            'visitant' => $visitant,
            'car' => $car,
            'balanceView' => $balance,
            'status' => ( $visit->status == 0 ) ? 'Em andamento' : 'Finalizada',
            'date' => [
                'day' =>  $day,
                'started' => (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $visit->started) , 'H:i:s')),
                'finished'=> (@date_format( @date_create_from_format(DATAMANAGER_CONFIG['datetimeformat'] , $visit->finished) , 'H:i:s'))
            ],
            'user' => (new UserModel())->find($visit->user)->only('name')->execute()->toEntity(),
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Visita', 'uri' => '/visita'],
                ['text' => 'Listagem', 'uri' => '/visita/listagem'],
                ['text' => 'Detalhes', 'active' => true],
            ]
        ]);
        
    }

}

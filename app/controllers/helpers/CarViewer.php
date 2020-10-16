<?php

namespace App\Controller\Helper;

use App\Helpers\Mask;
use App\Model\Visit as VisitModel;
use App\Model\Visitant as VisitantModel;
use App\Model\Car as Model;

trait CarViewer
{
    protected Model $entity;

    use Viewer,
        CarChecker,
        Mask;

    public function viewRegister()
    {
        $this->view([
            'page' => '/car/register.form',
            'title' => 'Novo veículo',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Veículo', 'uri' => '/veiculo'],
                ['text' => 'Novo veículo', 'active' => true]
            ]
        ]);
    }

    public function viewList(): void
    {
        $this->view([
            'page' => '/admin/list',
            'title' => 'Registros de veículos',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Veículo', 'uri' => '/veiculo'],
                ['text' => 'Listagem', 'active' => true]
            ],
            'tab' => [
                'id' => 'registersCars',
                'title' => 'Registro de veículos',
                'href' => '/veiculo/',
                'uri' => '/veiculo/listagem',
                'thead' => '<th>ID</th><th>Placa</th><th>Marca</th><th>Model</th><th>Cor</th><th>Eixos</th><th>Motorista</th><th>Ações</th>'
            ]
        ]);
    }

    public function viewMenu(): void
    {
        $this->view([
            'page' => '/car/menu',
            'title' => 'Veículos',
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Veículo', 'active' => true]
            ]
        ]);
    }

    public function viewEdition($id): void
    {
        $car = $this->entity->find($id)->where([
            ['id','<>',1]
        ])->execute()->toEntity();

        $this->throwCar($car);

        $cpf = (new VisitantModel())->find(intval($car->driver))->only('cpf')->execute()->toEntity()->cpf;

        $this->view([
            'page' => '/car/edition.form',
            'title' => 'Edição de veículo',
            'carView' => $car,
            'cpf' => $this->replace('cpf', $cpf),
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Veículo', 'uri' => '/veiculo'],
                ['text' => 'Listagem', 'uri' => '/veiculo/listagem'],
                ['text' => 'Edição', 'active' => true],
            ]
        ]);
    }

    public function viewDetails($id): void
    {
        $car = $this->entity->find($id)->where([
            ['id','<>',1]
        ])->execute()->toEntity();

        $this->throwCar($car);

        $lastvisit = (new VisitModel())->find()->only(['started','finished'])->where([
            'visitant', '=', $car->driver
        ])->orderBy(' started DESC ')->limit(1)->execute()->toEntity();

        $lastvisit = (is_null($lastvisit)) ? ['started' => '', 'finished' => ''] : ['started' => $lastvisit->started, 'finished' => $lastvisit->finished];

        $car->driver = (new VisitantModel())->find(intval($car->driver))->only('name')->execute()->toEntity()->name;

        $this->view([
            'page' => '/car/details',
            'title' => 'Detalhes de veículo',
            'carView' => $car,
            'lastvisit' => [ 'started' => $lastvisit['started'], 'finished' => $lastvisit['finished'] ],
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Veículo', 'uri' => '/veiculo'],
                ['text' => 'Listagem', 'uri' => '/veiculo/listagem'],
                ['text' => 'Detalhes', 'active' => true],
            ]
        ]);
    }

}

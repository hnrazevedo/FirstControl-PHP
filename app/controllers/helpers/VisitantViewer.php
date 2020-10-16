<?php

namespace App\Controller\Helper;

use App\Helpers\Mask;
use App\Model\Visitant as Model;

trait VisitantViewer
{
    protected Model $entity;

    use Viewer,
        Mask;

    public function viewRegister(): void
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
                'thead' => '<th>ID</th><th>Nome</th><th>CPF</th><th>RG</th><th>Últ. Visita</th><th>Empresa</th><th>Contato</th><th>Ações</th>'
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

    public function viewDetails($id): void
    {
        $visitant = $this->entity->find($id)->execute()->toEntity();

        $this->throwVisitant($visitant);

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

    public function viewEdition($id): void
    {
        $visitant = $this->entity->find($id)->execute()->toEntity();

        $this->throwVisitant($visitant);

        $visitant->cpf = $this->replaceCPF($visitant->cpf);
        $visitant->rg = $this->replaceRG($visitant->rg);
        $visitant->phone = $this->replaceCellPhone($visitant->phone);

        $this->view([
            'page' => '/visitant/edition.form',
            'title' => 'Edição de visitante',
            'visitantView' => $visitant,
            'breadcrumb' => [
                ['text' => 'Painel principal', 'uri' => '/dashboard'],
                ['text' => 'Visitante', 'uri' => '/visitante'],
                ['text' => 'Listagem', 'uri' => '/visitante/listagem'],
                ['text' => 'Edição', 'active' => true],
            ]
        ]);
    }

}

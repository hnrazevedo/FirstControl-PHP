<?php

namespace App\Controller\Helper;
use App\Helpers\Validate;

trait VisitantChecker
{
    use Viewer,
        Validate;

    protected function throwVisitant($visitant): self
    {
        if(null === $visitant){
            throw new \Exception('Visitante não encontrado');
        }
        return $this;
    }

    protected function throwCPF($cpf): self
    {
        if(!$this->isValidCPF($cpf)){
            throw new \Exception('CPF inválido');
        }
        return $this;
    }

}

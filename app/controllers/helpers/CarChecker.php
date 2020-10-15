<?php

namespace App\Controller\Helper;

trait CarChecker
{
    use Viewer;

    protected function checkCar($car): self
    {
        if(null === $car){
            throw new \Exception('Veículo não encontrado', 404);
        }
        return $this;
    }

    protected function checkDriver($visitant): self
    {
        if(is_null($visitant)){
            throw new \Exception('Motorista não cadastrado');
        }
        return $this;
    }

}

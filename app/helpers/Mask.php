<?php

namespace App\Helpers;

trait Mask{

    public function replaceCPF(string $cpf): string
    {
        return 
            substr($cpf,0,3).'.'.
            substr($cpf,3,3).'.'.
            substr($cpf,6,3).'-'.
            substr($cpf,9);
    }

    public function replaceRG(string $rg): string
    {
        return 
            substr($rg,0,2).'.'.
            substr($rg,2,3).'.'.
            substr($rg,5,3).'-'.
            substr($rg,8);
    }

    public function replaceCellPhone(string $phone): string
    {
        return 
            '('.substr($phone,0,2).') '.
            substr($phone,2,5).'-'.
            substr($phone,7);
    }

}
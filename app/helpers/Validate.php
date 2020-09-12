<?php

namespace App\Helpers;

trait Validate{
    
    public function isValidCPF(string $cpf): bool 
    {
        if(!preg_match('/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/',$cpf)){
            return false;
        } 
    
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    
}
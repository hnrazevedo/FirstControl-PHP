<?php

namespace App\Controller\Helper;

use App\Engine\Mail;

trait UserChecker
{
    use Viewer;

    protected function throwUser($user): self
    {
        if(null === $user){
            throw new \Exception('Usuário não encontrado.', 404);
        }
        return $this;
    }

    protected function throwStatus(string $status): self
    {
        if($status === '0'){
            throw new \Exception('Usuário bloqueado');
        } 
        return $this;
    }

    protected function throwPassword(string $password, string $value): self
    {
        if(!password_verify($password, $value)){
            throw new \Exception('Senha inválida');
        }
        return $this;
    }

    protected function throwAdmin(): self
    {
        if((unserialize($_SESSION['user']))->id != 1){
            throw new \Exception('Usuário é um administrador<br>Atualização não permitida');
        }
        return $this;
    }

    protected function throwMail(Mail $mail): self
    {
        if($mail->fail()){
            throw $mail->getError();
        }
        return $this;
    }
}

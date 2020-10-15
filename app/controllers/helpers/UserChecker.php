<?php

namespace App\Controller\Helper;

use App\Engine\Mail;

trait UserChecker
{
    use Viewer;

    protected function checkUser($user): self
    {
        if(null === $user){
            throw new \Exception('Usuário não encontrado.', 404);
        }
        return $this;
    }

    protected function checkStatus(string $status): self
    {
        if($status === '0'){
            throw new \Exception('Usuário bloqueado');
        } 
        return $this;
    }

    protected function checkPassword(string $password, string $value): self
    {
        if(!password_verify($password, $value)){
            throw new \Exception('Senha inválida');
        }
        return $this;
    }

    protected function checkAdmin(): self
    {
        if((unserialize($_SESSION['user']))->id != 1){
            throw new \Exception('Usuário é um administrador<br>Atualização não permitida');
        }
        return $this;
    }

    protected function checkMail(Mail $mail): self
    {
        if($mail->fail()){
            throw $mail->getError();
        }
        return $this;
    }
}

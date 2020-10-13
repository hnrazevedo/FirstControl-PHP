<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use HnrAzevedo\Router\Router;
use App\Model\Authorization as Model;
use App\Model\Permission;

class Authorization implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if(isset($_POST['PROVIDER'])){
            $this->checkForm($request);
            return $handler->handle($request->withAttribute('authorization', true));
        }

        $this->checkRoute($request);

        return $handler->handle($request->withAttribute('authorization', true));
    }

    private function checkRoute(ServerRequestInterface $request): void
    {
        if(isset($_SESSION['cache']['authorizations'])){
            if(!in_array(str_replace('\'', '', Router::currentName()), $_SESSION['cache']['authorizations']['routes'])){
                throw new \RuntimeException('Você não tem permissão para tal ação ['.Router::currentName().'][CACHE]', 401);
            }
            return;
        }

        $user = $request->getAttribute('user');
     
        $permission = (new Permission())->find()->where([
            ['reference', '=', str_replace('\'', '', Router::currentName())],
            ['type','=',0]
        ])->execute()->toEntity();

        if(null === $permission){
            throw new \RuntimeException('Permissão não cadastrada corretamente, contacte o administrador:<br>Route name: '.Router::currentName(), 401);
        }

        $auth = (new Model())->find()->where([
            ['user', '=', $user->id],
            ['permission', '=', $permission->id]
        ])->execute()->toEntity();


        if(null === $auth){
            throw new \RuntimeException('Você não tem permissão para tal ação ['.$permission->id.']', 401);
        }
    }

    private function checkForm(ServerRequestInterface $request)
    {
        $form = (isset($_POST['ROLE'])) ? $_POST['PROVIDER'].'|'.$_POST['ROLE'] : $_POST['PROVIDER'].'|';

        if(isset($_SESSION['cache']['authorizations'])){
            if(!in_array($form, $_SESSION['cache']['authorizations']['forms'])){
                throw new \RuntimeException('Você não tem permissão para tal ação ('.$form.')[CACHE]', 401);
            }
            return;
        }

        $user = $request->getAttribute('user');
     
        $permission = (new Permission())->find()->where([
            ['reference', '=', $form],
            ['type','=',1]
        ])->execute()->toEntity();

        if(null === $permission){
            throw new \RuntimeException('Você não tem permissão para tal ação ('.$form.')', 401);
        }

        $auth = (new Model())->find()->where([
            ['user', '=', $user->id],
            ['permission', '=', $permission->id]
        ])->execute()->toEntity();

        if(null === $auth){
            throw new \RuntimeException('Você não tem permissão para tal ação ('.$form.')', 401);
        }
    }
}

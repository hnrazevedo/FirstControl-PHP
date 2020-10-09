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

    private function checkRoute(ServerRequestInterface $request)
    {
        $user = $request->getAttribute('user');
     
        $permission = (new Permission())->find()->where([
            ['route', '=', str_replace('\'', '', Router::currentName())]
        ])->execute()->toEntity();

        if(null === $permission){
            throw new \RuntimeException('Você não tem permissão para tal ação ('.Router::currentName().')', 401);
        }

        $auth = (new Model())->find()->where([
            ['user', '=', $user->id],
            ['permission', '=', $permission->id]
        ])->execute()->toEntity();


        if(null === $auth){
            throw new \RuntimeException('Você não tem permissão para tal ação ('.Router::currentName().')', 401);
        }
    }

    private function checkForm(ServerRequestInterface $request)
    {
        $form = (isset($_POST['ROLE'])) ? $_POST['PROVIDER'].'|'.$_POST['ROLE'] : $_POST['PROVIDER'].'|';

        $user = $request->getAttribute('user');
     
        $permission = (new Permission())->find()->where([
            ['form', '=', $form]
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

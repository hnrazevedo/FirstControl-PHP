<?php

namespace App\Filter;

use HnrAzevedo\Filter\Filter as HnrFilter;

use App\Model\Authenticator as Model_auth;
use App\Model\Page as Model_page;

class Authenticator extends HnrFilter{

    private Model_auth $entityAuth;
    private Model_page $entityPage;

    public function __construct()
    {
        $this->entityAuth = new Model_auth();
        $this->entityPage = new Model_page();
    }

    public function authRoute(): bool
    {
        $route = unserialize($_SESSION['route']);
        $user = unserialize($_SESSION['user']);

        $modelPage = $this->entityPage->find()->only('id')->where([
            ['path','=',$route['url']],
            'OR' => [
                'path','=',substr($route['url'],0,-1)
            ]
        ])->execute();

        if($modelPage->getCount() === 0){
            $this->addMessage('authRoute','Permission settings for this page have not been defined by the administrator.');
            return false;
        }

        $modelPage = $modelPage->toEntity();

        $modelAuth = $this->entityAuth->find()->where([
            ['page','=',$modelPage->id],
            ['user','=',$user->id]
        ])->execute();

        if($modelAuth->getCount() === 0){
            $this->addMessage('authRoute','You do not have the necessary permissions.');
            return false;
        }
        
        return true;
    }

}


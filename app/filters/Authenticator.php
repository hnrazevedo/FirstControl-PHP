<?php

namespace Filter;

use HnrAzevedo\Filter\Filter;

use Model\Authenticator as Model_auth;
use Model\Page as Model_page;

class Authenticator extends Filter{

    private ?Model_auth $entityAuth;
    private ?Model_page $entityPage;

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
            ['path','=',$route['url']]
        ])->execute();

        if($modelPage->getCount() === 0){
            $this->addMessage('auth','Permission settings for this page have not been defined by the administrator.');
            return false;
        }

        $modelPage = $modelPage->toEntity();

        $modelAuth = $this->entityAuth->find()->where([
            ['page','=',$modelPage->id],
            ['user','=',$user->id]
        ])->execute();

        if($modelAuth->getCount() === 0){
            $this->addMessage('auth','You do not have the necessary permissions.');
            return false;
        }
        
        return true;
    }

}


<?php

namespace App\Filter;

use HnrAzevedo\Filter\Filter as HnrFilter;

class User extends HnrFilter{

    public function user_in(): bool
    {
        $this->addMessage('user_in','User required to be logged in.');
        return (array_key_exists('user',$_SESSION));
    }

}


<?php

use HnrAzevedo\Filter\Filter;

class User extends Filter{

    public function user_in(): bool
    {
        $this->addMessage('user_in','User required to be logged in.');
        return (array_key_exists('user',$_SESSION));
    }

}


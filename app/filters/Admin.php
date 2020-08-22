<?php

namespace App\Filter;

use HnrAzevedo\Filter\Filter as HnrFilter;

class Admin extends HnrFilter{

    public function is_admin(): bool
    {
        $this->addMessage('is_admin','User does not have the necessary permissions.');
        $user = unserialize($_SESSION['user']);
        return ($user->type == 1);
    }

}


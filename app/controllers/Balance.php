<?php

namespace App\Controller;

use App\Model\Balance as Model;

class Balance extends Controller
{
    public function __construct()
    {
        $this->entity = new Model();
    }

    public function register(array $data): int
    {
        $this->entity->input = $data['new_weight'];
        $this->entity->ending = 0;
        $this->entity->persist();
        return $this->entity->id;
    }

}

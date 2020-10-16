<?php

namespace App\Controller\Helper;

trait Viewer
{
    protected function view(array $data): void
    {
        \HnrAzevedo\Viewer\Viewer::path(SYSTEM['basepath'].'app/views/')->render('index', array_merge($data, $_SESSION['view']['data']));
    }
}

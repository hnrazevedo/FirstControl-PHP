<?php

namespace App\Controller\Helper;

trait Viewer
{
    public function view($data): void
    {
        \HnrAzevedo\Viewer\Viewer::path(SYSTEM['basepath'].'app/views/')->render('index', array_merge($data, $_SESSION['view']['data']));
    }
}

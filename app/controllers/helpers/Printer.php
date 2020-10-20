<?php

namespace App\Controller\Helper;

trait Printer
{
    public function print(array $data): void
    {
        \HnrAzevedo\Viewer\Viewer::path(SYSTEM['basepath'].'app/views/global')->render('print', array_merge($data, $_SESSION['view']['data']));
    }
}

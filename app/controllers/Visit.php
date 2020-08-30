<?php

namespace App\Controller;

use HnrAzevedo\Router\Controller;
use HnrAzevedo\Viewer\Viewer;

class Visit extends Controller{

    public function view_page()
    {
        Viewer::create(SYSTEM['basepath'].'app/views/visits/')->render('index',$_SESSION['view']['data']);
    }

}

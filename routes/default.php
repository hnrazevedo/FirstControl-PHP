<?php

use HnrAzevedo\Router\Router;


Router::get('/','Video:index');
Router::get('/page/{num_page}','Video:index');

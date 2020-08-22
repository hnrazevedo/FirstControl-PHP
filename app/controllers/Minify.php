<?php

namespace App\Controller;

use App\Engine\Logger;
use App\Engine\Minify as Engine;

class Minify{

    public function mify()
    {
        $_SESSION['save']['MINIFY'] = Engine::create(
            array(
                'path.css' => 'assets' . DIRECTORY_SEPARATOR . 'css',
                'path.js' => 'assets' . DIRECTORY_SEPARATOR . 'js'
            ),
            new Logger('SYSTEM')
        )->dispatch();
    }

}

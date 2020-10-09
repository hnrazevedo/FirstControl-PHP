<?php

namespace App\Engine;

use HnrAzevedo\Viewer\Viewer;
use Exception;
use App\Engine\Util as Util;

class Report
{
    private static $instance;
    private Exception $exception;

    public function __construct(Exception $er)
    {
        $this->exception = $er;
    }

    public static function create(Exception $er): Report
    {
        if(empty(self::$instance)){
            self::$instance = new self($er);
        }
        return self::$instance;
    }

    public function dispatch(): void
    {
        if(Util::getProtocol() === 'ajax'){
            echo json_encode(
                array(
                    'error'=>array(
                        'message' => $this->exception->getMessage(),
                        'code' => $this->exception->getCode()
                    )
                )
            );
            return;
        }

        $_SESSION['data'] = array(
            'message'=>$this->exception->getMessage(),
            'code'=>$this->exception->getCode()
        );

        Viewer::path(SYSTEM['basepath'].'app/views/')->render('error');
    }

}

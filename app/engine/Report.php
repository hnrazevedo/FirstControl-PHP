<?php

namespace Engine;

use HnrAzevedo\Viewer\Viewer;
use Exception;
use Engine\Util as Util;

Class Report{
    private static $instance;
    private ?Exception $exception;

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

    public function dispatch(): bool
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
            return true;
        }

        $_SESSION['data'] = array(
            'message'=>$this->exception->getMessage(),
            'code'=>$this->exception->getCode()
        );

        Viewer::create(SYSTEM['basepath'].'app/views/')->render('error');
        return true;
    }

}

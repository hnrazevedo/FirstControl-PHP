<?php

namespace Engine;

use HnrAzevedo\Router\Router;
use HnrAzevedo\Viewer\Viewer;
use Exception;

use Engine\Util as Util;

/**
 * Class Report
 * @package Engine
 */
Class Report{
    private static $instance;
    private ?Exception $exception;

    public function __construct(Exception $er){
        $this->exception = $er;
    }

    public static function create(Exception $er){
        if(empty(self::$instance)){
            self::$instance = new self($er);
        }
        return self::$instance;
    }

    public function dispatch(){
        if(Util::is('ajax')){
            echo json_encode(
                array(
                    'error'=>array(
                        'message'=>$this->exception->getMessage(),
                        'code'=>$this->exception->getCode()
                    )
                )
            );
            return true;
        }

        $_SESSION['data'] = array(
            'message'=>$this->exception->getMessage(),
            'code'=>$this->exception->getCode()
        );

        Viewer::create(BASEPATH.DS.'application'.DS.'views')->render('public/error');
    }

}

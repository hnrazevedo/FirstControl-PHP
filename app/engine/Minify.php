<?php

namespace App\Engine;

use MatthiasMullie\Minify as _Minify;

Class Minify{

    private static $instance = null;
    private $cssPath = null;
    private $jsPath = null;

    public function __construct(){
        return $this;
    }

    public static function create($config = array()){
        $instance = self::getInstance($config);
        return $instance;
    }

    public static function getInstance(?array $config = null){
        if(is_null(self::$instance)){
            self::$instance = new self();
            self::$instance->cssPath = (array_key_exists('path.css',$config)) ? $config['path.css'] : null;
            self::$instance->jsPath = (array_key_exists('path.js',$config)) ? $config['path.js'] : null;
        }
        return self::$instance;
    }

    public function dispatch(?string $type = null){
        /*$path = null;
        switch ($type) {
            case 'js':
                $path = BASEPATH.DIRECTORY_SEPARATOR.$this->jsPath;
                break;
            case 'css':
                $path = BASEPATH.DIRECTORY_SEPARATOR.$this->cssPath;
                break;
            default:
                $path = ['js' => BASEPATH.DIRECTORY_SEPARATOR.$this->jsPath, 'css' => BASEPATH.DIRECTORY_SEPARATOR.$this->cssPath];
                break;
        }

        $minifierCSS = new _Minify\CSS();
        $minifierJS = new _Minify\JS();


        if(is_array($path)){
            foreach ($path as $type => $file) {

                @unlink($file.DIRECTORY_SEPARATOR.'scripts.min.js');
                @unlink($file.DIRECTORY_SEPARATOR.'styles.min.css');

                foreach (scandir($file) as $fileMini) {
                    if(strtoupper(pathinfo($file.DIRECTORY_SEPARATOR.$fileMini, PATHINFO_EXTENSION)) === 'CSS'){
                        $minifierCSS->add($file.DIRECTORY_SEPARATOR.$fileMini);
                    }elseif(strtoupper(pathinfo($file.DIRECTORY_SEPARATOR.$fileMini, PATHINFO_EXTENSION)) === 'JS'){
                        $minifierJS->add($file.DIRECTORY_SEPARATOR.$fileMini);
                    }
                }

                if($type == 'js'){
                    if(!file_exists($file.DIRECTORY_SEPARATOR.'scripts.min.js')){
                        $minifierJS->minify($file.DIRECTORY_SEPARATOR.'scripts.min.js');
                    }
                }else{
                    if(!file_exists($file.DIRECTORY_SEPARATOR.'styles.min.css')){
                        $minifierCSS->minify($file.DIRECTORY_SEPARATOR.'styles.min.css');
                    }
                }
                $path[$type] = str_replace(BASEPATH.DIRECTORY_SEPARATOR,'',$path[$type]);
            }
            return ['js'=>str_replace(DIRECTORY_SEPARATOR,'/',$path['js']).'/scripts.min.js','css'=>str_replace(DIRECTORY_SEPARATOR,'/',$path['css']).'/styles.min.css'];
        }else{
            foreach (scandir($path) as $fileMini) {
                if(strtoupper(pathinfo($path.DIRECTORY_SEPARATOR.$fileMini, PATHINFO_EXTENSION)) === strtoupper($type)){
                    $m = 'minifier'.$type;
                    $m->add($path.DIRECTORY_SEPARATOR.$fileMini);
                }
            }
            if($type == 'js'){
                if(!file_exists($file.DIRECTORY_SEPARATOR.'scripts.min.js')){
                    $minifierJS->minify($file.DIRECTORY_SEPARATOR.'scripts.min.js');
                }
            }else{
                if(!file_exists($file.DIRECTORY_SEPARATOR.'styles.min.css')){
                    $minifierCSS->minify($file.DIRECTORY_SEPARATOR.'styles.min.css');
                }
            }
        }
        */
    }

}

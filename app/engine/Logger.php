<?php
namespace App\Engine;

use Psr\Log\LoggerInterface as LoggerInterface;
use Exception;

class Logger implements LoggerInterface{
    private ?string $level = null;
    private array $config = [];

    public function __construct(string $config)
    {
        try{
            if(!defined($config)){
                throw new Exception("Configuration file {$config} not found.");
            }
            $this->config = constant($config);
        }catch(Exception $er){
            throw $er;
        }
    }

    public function emergency($message, array $context = array())
    {
        $this->log('EMERGENCY', $message, $context);
    }

    public function alert($message, array $context = array())
    {
        $this->log('ALERT', $message, $context);
    }

    public function critical($message, array $context = array())
    {
        $this->log('CRITICAL', $message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->log('ERROR', $message, $context);
    }

    public function warning($message, array $context = array())
    {
        $this->log('WARNING', $message, $context);
    }

    public function notice($message, array $context = array())
    {
        $this->log('NOTICE', $message, $context);
    }

    public function info($message, array $context = array())
    {
        $this->log('INFO', $message, $context);
    }

    public function debug($message, array $context = array())
    {
        $this->log('DEBUG', $message, $context);
    }

    public function log($level, $message, array $context = array())
    {
        if(array_key_exists('logger.active',$this->config) && $this->config['logger.active'] == true){
            $this->level = $level;
            $path = $this->replace($this->config['logger.path'],$context);
            $filename = strtolower($this->replace($this->config['logger.filename'],$context));
            $path = SYSTEM['basepath'].str_replace(['\\','/'],DIRECTORY_SEPARATOR,$path);

            if(@mkdir($path,0777,true) === false){
                throw new \RuntimeException('The directory '.$path.' could not be created.');
            }

            file_put_contents($path.$filename,'['.$level.']['.$_SERVER['REMOTE_ADDR'].']['.date('d/m/Y h:m:s').']['.SYSTEM['uri'].'] [Message] '.$message . ' [Context] '.json_encode($context) ."\n",FILE_APPEND);
        }
    }

    private function replace($string,$context){
        $string = str_replace('%year%',date('Y'),$string);
        $string = str_replace('%mounth%',date('m'),$string);
        $string = str_replace('%day%',date('d'),$string);
        $string = str_replace('%level%',$this->level,$string);
        $string = (array_key_exists('task',$context)) ? str_replace('%task%',$context['task'],$string) : $string;
        return $string;
    }
}

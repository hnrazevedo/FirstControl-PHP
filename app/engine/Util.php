<?php
namespace App\Engine;

use ZipArchive;
use Exception;

Class Util{

    public static function getProtocol(): string
    {
        return (array_key_exists('HTTP_REQUESTED_METHOD',$_SERVER)) ? $_SERVER['HTTP_REQUESTED_METHOD'] : 'get';
    }

    public static function delete($path): bool
    {
		if(!file_exists($path)){
            return false;
        }   

        if(is_dir($path)){

            $dir = dir($path.'/');

            while($file = $dir->read()){

                if($file !== '.' && $file !== '..'){

                    if(is_dir($path.DS.$file)){
                        self::delete($path.DS.$file);
                    }

                }

            	@unlink($path.DS.$file);
            }

            $dir -> close();
            rmdir($path);
            return true;

        }
        
        unlink($path);
        return true;

	}

    public static function compressFolder(string $path, string $password)
    {
        $pathString = implode('-',(explode('/',$path)));

        $pathString = substr($pathString,0,strlen($pathString)-1);

        $fileName = $pathString .'['. date('d-m-Y h-m-s').'].zip';

        $path      = BASEPATH . DS . $path;
        $fileZip  = TEMPDIR. DS .$fileName;

        if(!file_exists($path)){
            throw new Exception("Diretório inexistente: {$path}.");
        }

        $scanDir = scandir($path);

        array_shift($scanDir);
        array_shift($scanDir);

        $zip = new ZipArchive();

        if( $zip->open($fileZip, ZipArchive::CREATE) ){

            $zip->setPassword($password);

            foreach($scanDir as $file){
                $zip->addFile("{$path}/{$file}", $file);
                $zip->setEncryptionName($file, ZipArchive::EM_AES_256);
            }

            $zip->close();
        }
    }

    public static function createTemp()
    {
        if(!file_exists(SYSTEM['temp'])){
            @mkdir(SYSTEM['temp']);
        }
    }

    public static function reindex(array $array): array
    {
        $array_return = [];
		foreach ($array as $key => $value) {
			$array = json_decode(json_encode($value), True);
			$array_return[$array['name']] = $array['value'];
		}
		return $array_return;
    }

    public static function getData(): array
    {
        return [
            'POST' => $_POST,
            'GET' => $_GET,
            'FILES' => $_FILES
        ];
    }
    
}

<?php
namespace App\Engine;

use ZipArchive;
use Exception;

class Util
{
    public static function getProtocol(): string
    {
        return (isset($_REQUEST['REQUEST_METHOD'])) ? $_REQUEST['REQUEST_METHOD'] : $_SERVER['REQUEST_METHOD'];
    }

    public static function delete($path): bool
    {
        if(is_dir($path)){

            $dir = dir($path.'/');

            while($file = $dir->read()){

                if(!in_array($file,['.','\\.','..'])){

                    if(is_dir($path.DIRECTORY_SEPARATOR.$file)){
                        self::delete($path.DIRECTORY_SEPARATOR.$file);
                    }

                    self::realUnlink($path.DIRECTORY_SEPARATOR.$file);
                }
            }

            $dir -> close();
            rmdir($path);
            return true;

        }
        
        self::realUnlink($path);
        return true;

    }
    
    private static function realUnlink(?string $path): void
    {
        if (@unlink($path) === false && isset($path) && file_exists($path)) {
            throw new \RuntimeException('The '.$path.' could not be remove.');
        }
    }

    public static function compressFolder(string $path, string $password): void
    {
        $pathString = implode('-',(explode('/',$path)));

        $pathString = substr($pathString,0,strlen($pathString)-1);

        $fileName = $pathString .'['. date('d-m-Y h-m-s').'].zip';

        $path      = SYSTEM['basepath'] . DIRECTORY_SEPARATOR . $path;
        $fileZip  = SYSTEM['temp'] . DIRECTORY_SEPARATOR .$fileName;

        if(!file_exists($path)){
            throw new Exception("Diretório inexistente: {$path}.");
        }

        $scanDir = scandir($path);

        $scanDir = (is_array($scanDir)) ? $scanDir : [];

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

    public static function createTemp(): void
    {
        if(!file_exists(SYSTEM['temp'])){
            if (@mkdir(SYSTEM['temp']) === false) {
                throw new \RuntimeException('The directory '.SYSTEM['temp'].' could not be created.');
            }
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

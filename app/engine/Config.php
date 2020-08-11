<?php

namespace Engine;

class Config{
    public static function import(string $path): void
    {
        foreach (scandir($path) as $configFile) {
            if(pathinfo("{$path}/{$configFile}", PATHINFO_EXTENSION) === 'php'){
                require_once("{$path}/{$configFile}");
            }
        }
    }
}
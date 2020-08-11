<?php

$path = __DIR__.'/../config/';

foreach (scandir($path) as $configFile) {
    if(pathinfo("{$path}/{$configFile}", PATHINFO_EXTENSION) === 'php'){
        require_once("{$path}/{$configFile}");
    }
}
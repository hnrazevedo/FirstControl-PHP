<?php

define("SYSTEM", [
    "instaled" => true,
    "appname" => "FirstControl",
    "uri" => "http://192.168.0.103",
    "temp" => __DIR__.'/../temp/'.session_id(),
    "basepath" => __DIR__.'/../',
    "version" => '0.1.0',

    "logger.path" => "/logs/system/%year%/%mounth%/",
    "logger.filename" => "%level%.%day%.log",
    "logger.maxsize" => "5MB",
    "logger.active" => true
]);
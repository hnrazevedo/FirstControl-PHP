<?php

define("SYSTEM", [
    "instaled" => true,
    "appname" => "FirstControl",
    "uri" => "https://localhost:4433",
    "temp" => __DIR__.'/../temp/'.session_id(),
    "basepath" => __DIR__.'/../',
    "version" => '0.1.0',
    "router.path" => __DIR__.'/../routes/'
]);
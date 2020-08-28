<?php

define("DATAMANAGER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "charset" => "utf8",
    "port" => 3306,
    "username" => "henri",
    "password" => "908077",
    "database" => "fControl",
    "timezone" => "America/Sao_Paulo",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
    ],
    "dateformat" => "d/m/Y",
    "datetimeformat" => "d/m/Y H:i:s"
]);
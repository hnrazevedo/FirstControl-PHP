<?php

define("MAIL", [
    "language" => "pt_br",
    "encoding" => "base64",
    "charset" => "UTF-8",
    "smtpDebug" => 0,
    "host" => "smtp.gmail.com",
    "smtpauth" => true,
    "username" => "hennry.vb@gmail.com",
    "password" => "ydzrfhtwuubpfga",
    "smtpsecure" => "tls",
    "port" => 587,

    "logger.path" => "/logs/mail/%year%/%mounth%/",
    "logger.filename" => "%level%.%day%.log",
    "logger.maxsize" => "5MB",
    "logger.active" => true
]);
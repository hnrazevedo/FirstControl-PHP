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

    "suporte.language" => "pt_br",
    "suporte.enconding" => "base64",
    "suporte.charset" => "UTF-8",
    "suporte.smtpdebug" => 0,
    "suporte.host" => "smtp.gmail.com",
    "suporte.smtpauth" => true,
    "suporte.username" => "hennry.vb@gmail.com",
    "suporte.password" => "fzstlpewrccrqye",
    "suporte.smtpsecure" => "tls",
    "suporte.port" => 587,

    "logger.path" => "/logs/mail/%year%/%mounth%/",
    "logger.filename" => "%level%.%day%.log",
    "logger.maxsize" => "5MB",
    "logger.active" => true
]);
/**
 * smtpdebug
 * 
 * DEBUG_OFF (`0`) No debug output, default
 * DEBUG_CLIENT (`1`) Client commands
 * DEBUG_SERVER (`2`) Client commands and server responses
 * DEBUG_CONNECTION (`3`) As DEBUG_SERVER plus connection status
 * DEBUG_LOWLEVEL (`4`) Low-level data output, all messages.
 */

/**
 * smtpsecure
 *
 * ENCRYPTION_STARTTLS (tls) - 587
 * ENCRYPTION_SMTPS  (ssl) - 465
 */

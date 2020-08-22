<?php
namespace App\Engine;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;
use Exception;

class Mail{
    
    private ?Phpmailer $phpmail = null;
    private ?Exception $fail = null;

    public function __construct($option)
    {
        $this->phpmail = new Phpmailer(true);
        $this->phpmail->isSMTP();
        $this->phpmail->setLanguage(MAIL["{$option}.language"], SYSTEM['basepath']."/vendor/phpmailer/phpmailer/language/");
        $this->phpmail->CharSet   = MAIL["{$option}.charset"];
        $this->phpmail->Encoding  = MAIL["{$option}.enconding"];
        $this->phpmail->SMTPDebug = MAIL["{$option}.smtpdebug"];
        $this->phpmail->Host       = MAIL["{$option}.host"];
        $this->phpmail->SMTPAuth   = MAIL["{$option}.smtpauth"];
        $this->phpmail->Username   = MAIL["{$option}.username"];
        $this->phpmail->Password   = MAIL["{$option}.password"];
        $this->phpmail->SMTPSecure = MAIL["{$option}.smtpsecure"];
        $this->phpmail->Port       = MAIL["{$option}.port"];
    }

    public function send(): bool
    {
        try{
            $this->phpmail->send();
            return true;
        }catch(MailException $er){
            $this->fail = new Exception("Infelizmente não foi possível enviar o email automatico:<br><br>{$this->phpmail->ErrorInfo}.",0, $er);
        }catch(Exception $er){
            $this->fail = $er;
        }
        return false;
    }

    public function addContent(string $html, string $nonHTML): Mail
    {
        $this->phpmail->isHTML(true);
        $this->phpmail->AltBody = $nonHTML;
        $this->phpmail->Body    = $html;
        return $this;
    }

    public function addSubject(string $subject): Mail
    {
        $this->phpmail->Subject = $subject;
        return $this;
    }

    public function addEmbeddedImage(string $path, string $name): Mail
    {
        $this->phpmail->AddEmbeddedImage($path,$name);
        return $this;
    }

    public function addAttachment(string $path, ?string $optional_name = null): Mail
    {
        $this->phpmail->addAttachment($path, $optional_name);
        return $this;
    }

    public function addTo(string $option, string $address, ?string $name = null): Mail
    {
        switch($option){
            case 'from':
                $this->phpmail->setFrom($address, $name);
                break;

            case 'address':
                $this->phpmail->addAddress($address, $name);
                break;

            case 'replyto':
                $this->phpmail->addReplyTo($address, $name);
                break;

            case 'cc':
                $this->phpmail->addCC($address, $name);
                break;

            case 'bcc':
                $this->phpmail->addBCC($address, $name);
                break;
        }
        return $this;
    }

    public function fail(): bool
    {
        return (!is_null($this->fail));
    }

    public function getError(): Exception
    {
        return $this->fail;
    }
}

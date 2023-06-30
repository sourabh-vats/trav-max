<?php
namespace App\Libraries;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Phpmailer_lib
{
    public function __construct()
    {
    }

    public function load(){
        require_once 'lib/PHPMailer/src/Exception.php';
        require_once 'lib/PHPMailer/src/PHPMailer.php';
        require_once 'lib/PHPMailer/src/SMTP.php';

        $mail = new PHPMailer();
        return $mail;
    }
}

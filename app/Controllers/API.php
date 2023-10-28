<?php

namespace App\Controllers;

require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class API extends BaseController
{
    public function __construct()
    {
        $session = session();
        if (!$session->is_customer_logged_in) {
            header('Location: /');
            die();
        }
    }

    public function get_notification(){
        
    }

}

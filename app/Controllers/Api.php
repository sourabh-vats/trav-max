<?php

namespace App\Controllers;
require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

helper('common');

class Api extends BaseController
{
    // public function __construct()
    // {
    //     $session = session();
    //     if (!$session->is_customer_logged_in) {
    //         header('Location: /');
    //         die();
    //     }
    // }

    public function get_partnership()
    {
        $db = db_connect();
        $query = $db->query('select * from partnership where user_id = "' . $_POST["userId"] . '"');
        $row = $query->getRowArray();
        if ($row != null) {
            $data = [
                'status' => "success",
                'data' => $row,
            ];
        } else {
            $data = [
                'status' => "fail",
                'data' => "No partnership found for the user.",
            ];
        }

        return $this->response->setJSON($data);
    }

    public function set_partnership()
    {
        $session = session();
        $userId = $session->get("cust_id");

        $db = db_connect();
        $query = $db->query('select * from partnership where user_id = "' . $userId . '"');
        $row = $query->getRowArray();
        if ($row != null) {
            $query = $db->query('UPDATE `partnership` SET `package_id` = "' . $_POST["packageId"] . '", `type` = "' . $_POST["partnership"] . '", `plan` = "' . $_POST["plan"] . '" WHERE (`user_id` = "' . $userId . '")');
            if ($query) {
                $data = [
                    'status' => "success",
                    'data' => $query,
                ];
            } else {
                $data = [
                    'status' => "fail",
                    'data' => "Some error happend can't update data.",
                ];
            }
        } else {
            $query = $db->query('insert into partnership (`user_id`, `package_id`, `type`, `plan`) VALUES ("' . $userId . '","' . $_POST["packageId"] . '", "' . $_POST["partnership"] . '", "' . $_POST["plan"] . '")');
            if ($query) {
                $data = [
                    'status' => "success",
                    'data' => $query,
                ];
            } else {
                $data = [
                    'status' => "fail",
                    'data' => "Some error happend can't insert data.",
                ];
            }
        }

        return $this->response->setJSON($data);
    }
    public function notification()
    {
        $session = session();
        $userId = $session->get("trav_id");
        $db = db_connect();
        $query = $db->query('select notify_msg from notify where cust_id = "' . $userId . '"');
        $row = $query->getRowArray();
        if ($row != null) {
            $data = [
                'status' => "success",
                'data' => $row,
            ];
        } else {
            $data = [
                'status' => "fail",
                'data' => "No Notification found for the user.",
            ];
        }
        return $this->response->setJSON($data);
    }

    public function get_otp()
    {
        $otp = generate_otp();
        $numbers = '919996250495';
        $message = $otp .' is your travmax account verification code.';

        $result = send_sms($numbers, $message);

        if ($result === true) {
            echo 'SMS sent successfully.';
        } elseif ($result === 'Insufficient credits') {
            echo 'Failed to send SMS: Insufficient credits.';
        } elseif ($result === 'Invalid number') {
            echo 'Failed to send SMS: Invalid number.';
        } else {
            echo 'Failed to send SMS: ' . $result;
        }
    }
}

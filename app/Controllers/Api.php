<?php

namespace App\Controllers;
require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Api extends BaseController
{
    public function __construct()
    {
        $session = session();
        if (!$session->is_customer_logged_in) {
            header('Location: /');
            die();
        }
    }

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
    
    public function delete_notification()
    {
        $session = session();
        $userId = $session->get("trav_id");

        $db = db_connect();
        $query = $db->query("DELETE FROM notify WHERE cust_id = '$userId'");

        if ($query) {
            $data = [
                'status' => 'success',
                'message' => 'Data deleted successfully.'
            ];
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Error deleting data from the database.'
            ];
        }

        return $this->response->setJSON($data);
    }

    public function send_mail(){

        $to = $this->request->getPost('to');
        $subject = $this->request->getPost('subject');
        $message = $this->request->getPost('message');
        $mail = new PHPMailer(true);
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            
            //for server settings
            // $mail->isSMTP();
            // $mail->Host = 'localhost';
            // $mail->SMTPAuth = false;
            // $mail->SMTPAutoTLS = false;
            // $mail->Port = 25;
        
            // //Recipients
            // $mail->setFrom('support@travmaxholidays.com', 'Travmax');
            // $mail->addAddress($to);     //Add a recipient
            // $mail->addReplyTo('info@travmaxholidays.com', 'Information');
            //end of server settings

            //For local settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.elasticemail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'sourabhvats96@gmail.com';                     //SMTP username
            $mail->Password   = 'D523B4735BB9E3503EF9C1257E0FBD6AD5BF';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('sourabhvats96@gmail.com', 'Travmax');
            $mail->addAddress($to);     //Add a recipient
            $mail->addReplyTo('info@travmaxholidays.com', 'Information');
            //end of local settings
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;


            // Set the view content as the email body
            $mail->Body = $message;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            $data = [
                'status' => 'success',
                'message' => 'Email sent successfully.'
            ];
        } catch (Exception $e) {
            $data = [
                'status' => 'error',
                'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
            ];       
         }
        return $this->response->setJSON($data);
    }
}

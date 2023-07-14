<?php

namespace App\Controllers;

require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User extends BaseController
{
    function validate_credentials()
    {
        $user_model = model('UserModel');
        $session = session();
        $user_name = $this->request->getPost("user_name");
        $password = $this->__encrip_password($this->request->getPost("password"));
        $is_valid = $user_model->validate_user($user_name, $password);

        if ($is_valid['login'] == 'false') {
            echo '<div class="alert alert-danger">Username or password is wrong.</div>';
        } elseif ($is_valid['login'] == 'true') {
            $data = array('full_name' => $is_valid['full_name'], 'email' => $is_valid['email'], 'trav_id' => $is_valid['trav_id'],  'cust_id' => $is_valid['cust_id'], 'cust_img' => $is_valid['cust_img'], 'booking_packages_number' => $is_valid['booking_packages_number'], 'is_customer_logged_in' => true);
            $session->set($data);
            //$user_model->update_profile($is_valid['trav_id'], array('last_visit' => date('Y-m-d H:i:s')));
            echo '<div class="alert alert-success">Login Successfull</div>';
        } else {
            echo '<div class="alert alert-danger">Some Error Occured.</div>';
        }
    }

    function create_member()
    {
        $validation = \Config\Services::validation();
        $validation->reset();
        // field name, error message, validation rules
        $validation->setRule('f_name', 'first name', 'trim|required|min_length[3]');
        $validation->setRule('l_name', 'last name', 'trim|required');
        $validation->setRule('number', 'phone', 'trim|required|numeric|min_length[10]|max_length[10]');
        $validation->setRule('email', 'email', 'trim|required|valid_email');
        $validation->setRule('password', 'password', 'trim|required|min_length[6]|max_length[32]');
        $validation->setRule('cpassword', 'confirm password', 'trim|required|min_length[6]|matches[password]');
        $validation->setRule('trav_id', 'Referral id', 'required');

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $value = empty($errors) ? "" : reset($errors);
            $data = array("status" => "error", "message" => $value);
            header("Content-Type: application/json");
            echo json_encode($data);
            exit();
        } else {
            $user_model = model('UserModel');
            $session = session();
            $query = $user_model->create_member();
        }
    }

    function __encrip_password($password)
    {
        return md5($password);
    }

    function logout()
    {
        $session = session();
        $session->destroy();
        header('Location: /');
        die();
    }

    function forgot_password()
    {
        if ($this->request->getMethod() === 'post') {
            $db = db_connect();
            $builder = $db->table('customer');
            $builder->select('*');
            $builder->where('email', $_POST["email"]);
            $query = $builder->get();
            $result = $query->getResultArray();
            if ($query->getNumRows() > 0) {
                $data = array("status" => "success", "message" => "Password Reset Link Has Been Sent To Your Email.");
                header("Content-Type: application/json");
                echo json_encode($data);
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    //$mail->isSMTP();
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );                                         //Send using SMTP
                    //$mail->Host       = 'smtp.elasticemail.com';                     //Set the SMTP server to send through
                    //$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    //$mail->Username   = 'sourabhvats96@gmail.com';                     //SMTP username
                    //$mail->Password   = 'D523B4735BB9E3503EF9C1257E0FBD6AD5BF';                               //SMTP password
                    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    //$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


                    $mail->isSMTP();
                    $mail->Host = 'localhost';
                    $mail->SMTPAuth = false;
                    $mail->SMTPAutoTLS = false;
                    $mail->Port = 25;

                    //Recipients
                    $mail->setFrom('support@travmaxholidays.com', 'Travmax');
                    $mail->addAddress($_POST["email"]);     //Add a recipient
                    $mail->addReplyTo('info@travmaxholidays.com', 'Information');

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Password Reset Link';

                    // Set the view content as the email body
                    $mail->Body = 'Hi ' . $result[0]['f_name'] . '<br><br>'
                        . 'Your reset password request has been received<br> Please click '
                        . 'the below link to reset your password.<br><br>'
                        . '<a href="' . base_url() . 'reset_password?token=' . $result[0]['customer_id'] . ' ">Click here<a><br>'
                        . 'Thanks <br> Travmax';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                exit();
            }
        } else {


            return view('forgot_password');
        }
    }

    public function reset_password()
    {

        if ($this->request->getMethod() === 'post') {
            $password = md5($_POST["password"]);
            $token = $_POST['token'];
            $db = db_connect();
            $query   = $db->query('UPDATE customer SET pass_word = "' . $password . '" WHERE customer_id = "' . $token . '"');
            $data = array("status" => "success", "message" => "Password Changed.");
            header("Content-Type: application/json");
            echo json_encode($data);
            exit();
        } else {
            return view('reset_password');
        }
    }
}

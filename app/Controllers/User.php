<?php

namespace App\Controllers;

helper('common');

require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\Database\Exceptions\DatabaseException;

class User extends BaseController
{
    function validate_credentials()
    {
        $user_model = model('UserModel');
        $session = session();
        $user_name = $this->request->getPost("user_name");
        $password = $this->__encrip_password($this->request->getPost("password"));
        $is_valid = $user_model->validate_user($user_name, $password);
        if ($is_valid['login'] == 'true') {
            $data = array('full_name' => $is_valid['full_name'], 'email' => $is_valid['email'], 'trav_id' => $is_valid['trav_id'],  'cust_id' => $is_valid['cust_id'], 'cust_img' => $is_valid['cust_img'], 'booking_packages_number' => $is_valid['booking_packages_number'], 'is_customer_logged_in' => true);
            $session->set($data);
        }
        $is_valid = json_encode($is_valid);
        echo $is_valid;
    }

    function create_member()
    {
        try {
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
                $number = $_POST["number"];
                $otp = $this->request->getPost('otp');
                $email = $this->request->getPost('email');

                $db = db_connect();
                $builder = $db->table('customer');
                $builder->select('*');
                $builder->where('phone', $_POST["number"]);
                $query = $builder->get();

                if ($query->getNumRows() > 0) {
                    $data = array("status" => "error", "message" => "Phone number already exists.");
                    header("Content-Type: application/json");
                    echo json_encode($data);
                    exit();
                }
                $builder = $db->table('customer');
                $builder->select('*');
                $builder->where('email', $email);
                $query = $builder->get();

                if ($query->getNumRows() > 0) {
                    $data = array("status" => "error", "message" => "Email already exists.");
                    header("Content-Type: application/json");
                    echo json_encode($data);
                    exit();
                } else {
                    $db = db_connect();
                    $builder = $db->table('customer');
                    $builder->select('*');
                    $builder->where('customer_id', $_POST["trav_id"]);
                    $query = $builder->get();
                    $referralCustomer = $query->getRow();
                    if ($query->getNumRows() == 0) {
                        $data = array("status" => "error", "message" => "Referral ID doesn't exist.");
                        header("Content-Type: application/json");
                        echo json_encode($data);
                        exit();
                    } else  if ($referralCustomer->status != 'active') {
                        $data = array("status" => "error", "message" => "Referral ID is not active.");
                        header("Content-Type: application/json");
                        echo json_encode($data);
                        exit();
                    }
                }


                $otpRow = $db->table('otp')
                    ->where('email', $email)
                    ->get()
                    ->getRow();

                if ($otpRow && $otpRow->otp == $otp) {
                    $user_model = model('UserModel');
                    $session = session();
                    $query = $user_model->create_member();
                } else if ($_POST['otp'] == "") {
                    $otp = generate_otp();
                    $numbers = '91' . $_POST["number"];
                    $message = $otp . ' is your travmax account verification code.';

                    $result = send_sms($numbers, $message);

                    if ($result === true) {
                    } else {
                        echo 'Failed to send SMS: ' . $result;
                    }
                    $mail = new PHPMailer(true);

                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    $mail->isSMTP();
                    $mail->Host = 'localhost';
                    $mail->SMTPAuth = false;
                    $mail->SMTPAutoTLS = false;
                    $mail->Port = 25;

                    //Recipients
                    $mail->setFrom('support@travmaxholidays.com', 'Travmax');
                    $mail->addAddress($_POST['email']);     //Add a recipient
                    $mail->addReplyTo('info@travmaxholidays.com', 'Information');

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'OTP';

                    // Set the view content as the email body
                    $mail->Body = 'OTP for Completing the registraton is this: ' . $otp;
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();

                    $email = $_POST['email'];
                    $db = db_connect();

                    $existingRecord = $db->table('otp')->where('email', $email)->get();

                    if ($existingRecord->getNumRows() > 0) {
                        // If a record exists, update the OTP for that email
                        $db->table('otp')->where('email', $email)->update(['otp' => $otp]);
                    } else {
                        // If no record exists, insert a new one
                        $data_to_store = [
                            'email' => $email,
                            'otp' => $otp
                        ];
                        $db->table('otp')->insert($data_to_store);
                    }
                    $data = array("status" => "error", "message" => "An OTP has been sent to your registered email and mobile number. Please check and submit.");
                    header("Content-Type: application/json");
                    echo json_encode($data);
                    exit();
                } else {
                    $data['status'] = 'error';
                    $data['message'] = 'Invalid OTP';
                    header('Content-Type: application/json');
                    echo json_encode($data);
                    exit();
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        } catch (DatabaseException $e) {
            echo $e->getMessage();
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
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    // $mail->isSMTP();
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );                                         //Send using SMTP
                    // $mail->Host       = 'smtp.elasticemail.com';                     //Set the SMTP server to send through
                    // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    // $mail->Username   = 'sourabhvats96@gmail.com';                     //SMTP username
                    // $mail->Password   = 'D523B4735BB9E3503EF9C1257E0FBD6AD5BF';                               //SMTP password
                    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    // $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


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

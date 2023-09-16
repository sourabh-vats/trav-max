<?php
require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Create an instance; passing `true` enables exceptions
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
    $mail->addAddress($profile[0]['email']);     //Add a recipient
    $mail->addReplyTo('info@travmaxholidays.com', 'Information');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Congrats ! You are a Travmax Partner';
    $data['name'] =  $profile[0]['f_name'] . ' ' . $profile[0]['l_name'];
    $data['email'] =  $profile[0]['email'];

    $view = view('content', $data);

    // Set the view content as the email body
    $mail->Body = $view;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
if (isset($_SESSION['upgrade']) && $_SESSION['upgrade'] === true) {
    echo '<div class="alert alert-success">You have successfully upgraded your account and became a partner.</div>';
    
    unset($_SESSION['upgrade']);
}
?>

<div class="row d-flex justify-content-center flex-wrap">
    <div class="col-md-6 p-5 border-end text-center">
        <h2 >Congratulations</h2><br><br>
        <h4 class="text-center">You have selected <?php echo $package_data[0]['display_name']; ?> Package for Rs. <?php echo $package_data[0]['total']; ?> <?php if ($booking_packages_number > 1) {
                                                                                                                                                                echo 'per person for ' . $booking_packages_number . ' persons';
                                                                                                                                                            } ?> and have taken the <?php echo $package_information[0]['payment_type']; ?>. Please make a payment of Rs. <?php echo $payment_amount * $booking_packages_number . '(' . $payment_amount . '*' . $booking_packages_number . ')'; ?> and share the proof with us</h4>
        <img src="/images/travel_img.jpeg" alt="" width="100%" style="background-color: grey;">
    </div>
    <div class="col-md-6 p-5 text-center">
        <h2>Pay Here</h2>
        <br>
        <div style="display: flex;">
        <div class="p-3" style="display: flex; flex-direction: column; align-items: center;">
            <img src="/images/tarvmax_qr_code.jpeg" alt="" width="200px" style="background-color: grey; display: block;">
            <img src="/images/travmax_vpa.jpeg" alt="" width="200px" style="background-color: grey; display: block; margin-top: 10px;">
        </div>
<div class="p-3" style="padding-top: 100px;">
        <h5>Travmax Holidays (Current Account)</h5>
        <h5>Account No: 2221238344613985</h5>
        <h5>Bank Name: AU Small Finance Bank</h5>
        <h5>IFSC: AUBL0002383</h5>
        <h5>Branch: Sector 8, Chandigarh</h5>
        </div>
    </div>
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-center gap-2 my-3">
        <a class="btn btn-primary" href="/admin">Dashboard</a>
        <a class="btn btn-primary" href="/admin/request-fund">Upload Proof</a>
        <a class="btn btn-success" href="https://wa.me/9216003333"><i class="bi-whatsapp me-2"></i>WhatsApp</a>
    </div>
</div>
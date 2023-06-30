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
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.elasticemail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'sourabhvats96@gmail.com';                     //SMTP username
    $mail->Password   = 'D523B4735BB9E3503EF9C1257E0FBD6AD5BF';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('support@travmaxholidays.com', 'Travmax');
    $mail->addAddress('sourabhsharma94676@gmail.com');     //Add a recipient
    $mail->addReplyTo('info@travmaxholidays.com', 'Information');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Account Created';
    $mail->Body    = 'Hello ' . $profile[0]['f_name'] . ' ' . $profile[0]['l_name'] .',

    Thank you. We are delighted to have you with us.<br> We hope you find in our business what you are looking for. Someone from our customer care team will get in touch within 24 hours.
    <br><br>
    Respectfully,<br>
    Travmax';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>

<div class="row d-flex justify-content-center flex-wrap">
    <h1 class="text-center">Congratulations</h1>
    <h2 class="text-center">You have selected <?php echo $package_data[0]['name']; ?>Package for Rs. <?php echo $package_data[0]['total']; ?> <?php if ($booking_packages_number > 1) {
                                                                                                                                                    echo 'per person for ' . $booking_packages_number . ' persons';
                                                                                                                                                } ?> and have taken the <?php echo $package_information[0]['payment_type']; ?>. Please make a payment of Rs. <?php echo $payment_amount * $booking_packages_number . '(' . $payment_amount . '*' . $booking_packages_number . ')'; ?> and share the proof with us</h2>
    <div class="col-md-6 p-5 border-end text-center">
        <h2 class="">QR Code</h2>
        <img src="/images/travmax_qr.jpeg" alt="" width="300px" style="background-color: grey;">
    </div>
    <div class="col-md-6 p-5 text-center">
        <h2>Bank Information</h2>
        <br>
        <h5>Travmax Holidays (Current Account)</h5>
        <h5>Account No: 2221238344613985</h5>
        <h5>Bank Name: AU Small Finance Bank</h5>
        <h5>IFSC: AUBL0002383</h5>
        <h5>Branch: Sector 8, Chandigarh</h5>
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-center gap-2 my-3">
        <a class="btn btn-primary" href="/admin">Dashboard</a>
        <a class="btn btn-primary" href="/admin/request-fund">Upload Proof</a>
        <a class="btn btn-success" href="https://wa.me/9216003333"><i class="bi-whatsapp me-2"></i>WhatsApp</a>
    </div>
</div>
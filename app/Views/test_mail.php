<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $to = "sourabhvats96@gmail.com";
    $subject = "Test mail";
    $message = "Hello! This is a simple email message.";
    $from = "sourabhsharma94676@gmail.com";

    $headers = [ "MIME-Version:1.0",
    "Content-type: text/plain; charset=utf-8",
    "From: hello@yahoobaba.net",
    "Cc: findjquery@gmail.com",
    "Bcc: abc@gmail.com"
    ];

    $headers = implode("\r\n",$headers);

    if(mail($to ,$subject,$message,$headers)){
    echo "Email Sent.";
    }else{
    echo "Email Failed.";
    }
    ?>
</body>

</html>
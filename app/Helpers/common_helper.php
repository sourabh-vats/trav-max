<?php

function encrypt_data($data) {
    // Your encryption logic here
    // ...
    return "test";
}

function decrypt_data($encrypted_data) {
    // Your decryption logic here
    // ...
    return "test";
}

function generate_otp($length = 4) {
    $otp = '';
    $characters = '0123456789';
    $characters_length = strlen($characters);

    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, $characters_length - 1)];
    }

    return $otp;
}


function send_sms($numbers, $message, $apiKey = "NGYzMzQ2NGU3MjQxNmYzMjRlNTQ2OTc1NTg1MDYxMzI=", $sender = "TRVMAX") {
    $url = 'https://api.textlocal.in/send/';

    $postData = array(
        'apikey' => $apiKey,
        'sender' => $sender,
        'numbers' => $numbers,
        'message' => $message
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response, true);
    if ($result && isset($result['status'])) {
        if ($result['status'] == 'success') {
            // SMS sent successfully
            return true;
        } elseif ($result['status'] == 'failure') {
            // SMS sending failed
            if (isset($result['errors'])) {
                $errors = implode(', ', $result['errors']);
                if (strpos($errors, 'Insufficient credits') !== false) {
                    // Handle insufficient credits error
                    return 'Insufficient credits';
                } elseif (strpos($errors, 'Invalid number') !== false) {
                    // Handle invalid number error
                    return 'Invalid number';
                } else {
                    // Handle other failure errors
                    return 'SMS sending failed: ' . $errors;
                }
            }
        }
    }

    // Handle unknown response or other errors
    return 'Unknown error';
}

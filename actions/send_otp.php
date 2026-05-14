<?php

session_start();

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Content-Type: application/json");

$env = parse_ini_file("../.env");

$email = $_POST['email'];

$otp = rand(100000,999999);

$_SESSION['otp'] = $otp;

$_SESSION['signup_data'] = $_POST;

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();

    $mail->Host =
        $env['MAIL_HOST'];

    $mail->SMTPAuth = true;

    $mail->Username =
        $env['MAIL_USER'];

    $mail->Password =
        $env['MAIL_PASS'];

    $mail->SMTPSecure = 'tls';

    $mail->Port =
        $env['MAIL_PORT'];

    $mail->setFrom(
        $env['MAIL_USER'],
        'SmartGruh'
    );

    $mail->addAddress($email);

    $mail->Subject =
        'SmartGruh OTP Verification';

    $mail->Body =
        "Your OTP is: $otp";

    $mail->send();

    echo json_encode([

        "status" => "success",

        "message" =>
        "OTP Sent Successfully"

    ]);

} catch (Exception $e) {

    echo json_encode([

        "status" => "error",

        "message" =>
        $mail->ErrorInfo

    ]);

}

?>
<?php

session_start();

require_once '../config/db.php';

header("Content-Type: application/json");

if(!isset($_SESSION['otp'])){

    echo json_encode([
        "status" => "error",
        "message" => "OTP Expired"
    ]);

    exit;
}

$user_otp = $_POST['otp'];

if($user_otp == $_SESSION['otp']){

    $data = $_SESSION['signup_data'];

    $full_name = $data['full_name'];

    $email = $data['email'];

    $phone = $data['phone'];

    $password = password_hash(
        $data['password'],
        PASSWORD_DEFAULT
    );

    $role = $data['role'];

    $check = $conn->prepare(
        "SELECT id FROM users
         WHERE email=?"
    );

    $check->bind_param(
        "s",
        $email
    );

    $check->execute();

    $result = $check->get_result();

    if($result->num_rows > 0){

        echo json_encode([
            "status" => "error",
            "message" => "Email Already Exists"
        ]);

        exit;
    }

    $stmt = $conn->prepare(

        "INSERT INTO users
        (full_name,email,phone,password,role)
        VALUES(?,?,?,?,?)"

    );

    $stmt->bind_param(

        "sssss",

        $full_name,
        $email,
        $phone,
        $password,
        $role

    );

    if($stmt->execute()){

        unset($_SESSION['otp']);

        echo json_encode([
            "status" => "success",
            "message" => "Signup Successful"
        ]);

    } else {

        echo json_encode([
            "status" => "error",
            "message" => "Database Insert Failed"
        ]);

    }

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Invalid OTP"
    ]);

}

?>
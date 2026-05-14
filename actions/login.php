<?php

session_start();

require_once '../config/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare(
    "SELECT * FROM users
     WHERE email=?"
);

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows > 0){

    $user = $result->fetch_assoc();

    if(
        password_verify(
            $password,
            $user['password']
        )
    ){

        $_SESSION['user_id']
            = $user['id'];

        $_SESSION['name']
            = $user['full_name'];

        $_SESSION['role']
            = $user['role'];

        header(
            "Location: ../public/dashboard.php"
        );

        exit;

    } else {

        echo "Wrong Password";

    }

} else {

    echo "User Not Found";

}

?>
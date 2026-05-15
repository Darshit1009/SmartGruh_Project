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

        if ($user['role'] == 'admin') {
            header("Location: ../public/admin_dashboard.php");
        } elseif ($user['role'] == 'electrician') {
            header("Location: ../public/electrician_dashboard.php");
        } else {
            header("Location: ../public/user_dashboard.php");
        }

        exit;

    } else {

        echo "Wrong Password";

    }

} else {

    echo "User Not Found";

}

?>
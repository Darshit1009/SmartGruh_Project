<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: login.php");
    exit;

}

if($_SESSION['role'] == 'admin'){

    header("Location: admin_dashboard.php");

}
elseif($_SESSION['role'] == 'electrician'){

    header("Location: electrician_dashboard.php");

}
else{

    header("Location: user_dashboard.php");

}

exit;

?>
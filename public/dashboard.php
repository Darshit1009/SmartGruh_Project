<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] == 'admin') {
    header("Location: admin_dashboard.php");
    exit;
} elseif ($_SESSION['role'] == 'electrician') {
    header("Location: electrician_dashboard.php");
    exit;
} else {
    header("Location: user_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>SmartGruh Dashboard</title>

    <style>

        body{
            background:#0f172a;
            color:white;
            font-family:Arial;
            padding:40px;
        }

        .card{
            background:#1e293b;
            padding:30px;
            border-radius:12px;
            width:300px;
        }

        h1{
            color:#38bdf8;
        }

        button{

            width:100%;
            padding:15px;
            margin-top:15px;

            border:none;
            border-radius:8px;

            font-size:18px;
            font-weight:bold;

            cursor:pointer;
        }

        .on{
            background:green;
            color:white;
        }

        .off{
            background:red;
            color:white;
        }

        #status{
            margin-top:20px;
            color:#38bdf8;
        }

    </style>

</head>

<body>

    <h1>SmartGruh Dashboard</h1>

    <div class="card">

        <h2>Room LED</h2>

        <button class="on" onclick="toggleLed(1)">
            TURN ON
        </button>

        <button class="off" onclick="toggleLed(0)">
            TURN OFF
        </button>

        <p id="status">
            Waiting...
        </p>

    </div>

<script>

function toggleLed(state)
{
    fetch("toggle_switch.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        body: "state=" + state

    })
    .then(response => response.json())
    .then(data => {

        console.log(data);

        if(data.success){

            document.getElementById("status").innerHTML =
                "MQTT Sent Successfully : " + state;

        } else {

            document.getElementById("status").innerHTML =
                "Error : " + data.message;
        }

    })
    .catch(error => {

        console.log(error);

        document.getElementById("status").innerHTML =
            "Connection Error";

    });
}

</script>

</body>
</html>
<?php

require_once '../includes/auth.php';
require_once '../config/db.php';

$env = parse_ini_file(__DIR__ . "/../.env");

if($_SESSION['role'] != 'electrician'){

    if ($_SESSION['role'] == 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit;

}

$users = $conn->query(

"SELECT * FROM users
 WHERE role='user'"

);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Electrician Dashboard
</title>

<link rel="stylesheet"
href="../assets/style.css">

<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

<style>

.user-grid{

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(320px,1fr));

gap:25px;

margin-top:30px;

}

.user-card{

background:#334155;

padding:25px;

border-radius:22px;

box-shadow:
0 8px 22px rgba(0,0,0,0.28);

transition:0.3s;

}

.user-card:hover{

transform:
translateY(-6px);

}

.user-icon{

font-size:60px;

margin-bottom:18px;

}

.user-name{

font-size:30px;

font-weight:bold;

margin-bottom:12px;

color:white;

}

.user-email{

font-size:16px;

color:#cbd5e1;

margin-bottom:12px;

word-break:break-word;

}

.mqtt-grid{

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(320px,1fr));

gap:25px;

margin-top:25px;

}

.mqtt-card{

background:#334155;

padding:28px;

border-radius:22px;

box-shadow:
0 8px 22px rgba(0,0,0,0.28);

transition:0.3s;

}

.mqtt-card:hover{

transform:
translateY(-5px);

}

.mqtt-icon{

font-size:58px;

margin-bottom:18px;

}

.mqtt-title{

font-size:28px;

font-weight:bold;

margin-bottom:15px;

color:white;

}

.mqtt-status{

font-size:18px;

font-weight:bold;

color:#38bdf8;

margin-top:10px;

}

</style>

</head>

<body>

<div class="navbar">

<h2>
SmartGruh
</h2>

<div>

<a href="../actions/logout.php">
Logout
</a>

</div>

</div>

<div class="dashboard">

<h1>
Electrician Dashboard
</h1>

<h2>
Welcome
<?php echo $_SESSION['name']; ?>
</h2>

<!-- MQTT SECTION -->

<div class="card">

<h2 style="
font-size:34px;
margin-bottom:30px;
">

ESP32 MQTT Control

</h2>

<div class="mqtt-grid">

<!-- MQTT STATUS CARD -->

<div class="mqtt-card">

<div class="mqtt-icon">
📡
</div>

<div class="mqtt-title">

MQTT Status

</div>

<div id="status"
class="mqtt-status">

Connecting...

</div>

</div>

<!-- FAN CONTROL CARD -->

<div class="mqtt-card">

<div class="mqtt-icon">
🪭
</div>

<div class="mqtt-title">

Fan Control

</div>

<button onclick="turnOn()">

Turn ON Fan

</button>

<br><br>

<button onclick="turnOff()">

Turn OFF Fan

</button>

</div>

</div>

</div>

<!-- USER CARDS -->

<div class="card">

<h2 style="font-size:34px;">
User Room Management
</h2>

<p style="
margin-bottom:30px;
color:#cbd5e1;
">

Manage rooms and smart switchboards.

</p>

<div class="user-grid">

<?php while($user = $users->fetch_assoc()) { ?>

<div class="user-card">

<div class="user-icon">
👤
</div>

<div class="user-name">

<?php echo $user['full_name']; ?>

</div>

<div class="user-email">

<?php echo $user['email']; ?>

</div>

<p style="
margin-bottom:22px;
color:#94a3b8;
font-size:15px;
">

Role :
<?php echo ucfirst($user['role']); ?>

</p>

<a href="manage_room.php?user_id=<?php echo $user['id']; ?>">

<button>

Manage Rooms

</button>

</a>

</div>

<?php } ?>

</div>

</div>

</div>

<script>

const client = mqtt.connect(

'<?php echo $env['MQTT_HOST']; ?>',

{
username:'<?php echo $env['MQTT_USER']; ?>',
password:'<?php echo $env['MQTT_PASS']; ?>'
}

);

client.on('connect',()=>{

document
.getElementById("status")
.innerHTML =
"MQTT Connected";

client.subscribe(
"home/room/fan"
);

});

client.on('message',(topic,message)=>{

document
.getElementById("status")
.innerHTML =
"Relay : " + message.toString();

});

function turnOn(){

client.publish(
"home/room/fan",
"ON"
);

}

function turnOff(){

client.publish(
"home/room/fan",
"OFF"
);

}

</script>

</body>
</html>
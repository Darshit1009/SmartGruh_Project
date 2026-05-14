<?php

require_once '../includes/auth.php';
require_once '../config/db.php';

$env = parse_ini_file(__DIR__ . "/../.env");

if($_SESSION['role'] != 'electrician'){

    header("Location: dashboard.php");
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

<!-- MQTT CONTROL -->

<div class="card">

<h2>
ESP32 MQTT Control
</h2>

<h3 id="status">
Connecting...
</h3>

<br>

<button onclick="turnOn()">
Turn ON Fan
</button>

<br><br>

<button onclick="turnOff()">
Turn OFF Fan
</button>

</div>

<br>

<!-- USER CARDS -->

<h2>
User Room Management
</h2>

<?php while($user = $users->fetch_assoc()) { ?>

<div class="card">

<h3>
<?php echo $user['full_name']; ?>
</h3>

<p>
<?php echo $user['email']; ?>
</p>

<p>
Role :
<?php echo $user['role']; ?>
</p>

<br>

<a href="manage_room.php?user_id=<?php echo $user['id']; ?>">

<button>
Manage Rooms
</button>

</a>

</div>

<br>

<?php } ?>

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
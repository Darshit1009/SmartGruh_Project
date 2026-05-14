<?php

require_once '../includes/auth.php';
require_once '../config/db.php';

if($_SESSION['role'] != 'electrician'){

    header("Location: dashboard.php");
    exit;

}

if(!isset($_GET['user_id'])){

    die("User ID Missing");

}

$user_id = $_GET['user_id'];

$user_stmt = $conn->prepare(

"SELECT * FROM users
 WHERE id=?"

);

$user_stmt->bind_param("i", $user_id);

$user_stmt->execute();

$user_query = $user_stmt->get_result();

$user = $user_query->fetch_assoc();

if(isset($_POST['room_name'])){

    $room_name = $_POST['room_name'];

    $stmt = $conn->prepare(

    "INSERT INTO rooms
    (room_name,user_id)
    VALUES(?,?)"

    );

    $stmt->bind_param(
    "si",
    $room_name,
    $user_id
    );

    $stmt->execute();

}

$rooms_stmt = $conn->prepare(

"SELECT * FROM rooms
 WHERE user_id=?"

);

$rooms_stmt->bind_param("i", $user_id);

$rooms_stmt->execute();

$rooms = $rooms_stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Manage Rooms
</title>

<link rel="stylesheet"
href="../assets/style.css">

</head>

<body>

<div class="navbar">

<h2>
SmartGruh
</h2>

<div>

<a href="electrician_dashboard.php">
Back
</a>

<a href="../actions/logout.php">
Logout
</a>

</div>

</div>

<div class="dashboard">

<h1>
Manage Rooms
</h1>

<h2>
User :
<?php echo $user['full_name']; ?>
</h2>

<div class="card">

<form method="POST">

<input type="text"
name="room_name"
placeholder="Enter Room Name"
required>

<button type="submit">
Add Room
</button>

</form>

</div>

<br>

<h2>
Available Rooms
</h2>

<?php while($room = $rooms->fetch_assoc()) { ?>

<div class="card">

<h3>
<?php echo $room['room_name']; ?>
</h3>

<br>

<a href="switchboard.php?room_id=<?php echo $room['id']; ?>">

<button>
Open Switchboard
</button>

</a>

</div>

<br>

<?php } ?>

</div>

</body>
</html>
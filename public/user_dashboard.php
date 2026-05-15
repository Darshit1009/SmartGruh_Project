<?php
require_once '../includes/auth.php';

if ($_SESSION['role'] !== 'user') {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: electrician_dashboard.php");
    }
    exit;
}

require_once '../config/db.php';

$user_id = $_SESSION['user_id'];

$rooms_stmt = $conn->prepare(
    "SELECT * FROM rooms WHERE user_id=?"
);

$rooms_stmt->bind_param(
    "i",
    $user_id
);

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
User Dashboard
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

        <a href="../actions/logout.php">
        Logout
        </a>

    </div>

</div>

<div class="dashboard">

<h1>
User Dashboard
</h1>

<h2>
Welcome
<?php echo $_SESSION['name']; ?>
</h2>

<div class="card">

<h3 style="font-size:32px;">
Your Rooms
</h3>

<p style="margin-bottom:30px;">
Select a room to manage your switches.
</p>

<?php if($rooms->num_rows > 0): ?>

<div style="

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(320px,1fr));

gap:25px;

">

<?php while($room = $rooms->fetch_assoc()): ?>

<div style="

background:#334155;

padding:25px;

border-radius:18px;

box-shadow:
0 6px 18px rgba(0,0,0,0.3);

transition:0.3s;

">

<div style="font-size:55px;">
🏠
</div>

<h2 style="
margin-top:15px;
margin-bottom:15px;
color:white;
">

<?php echo ucfirst($room['room_name']); ?>

</h2>

<p style="
color:#cbd5e1;
margin-bottom:20px;
">

Smart room switchboard access

</p>

<a href="switchboard.php?room_id=<?php echo $room['id']; ?>">

<button>

Open Switchboard

</button>

</a>

</div>

<?php endwhile; ?>

</div>

<?php else: ?>

<div style="
padding:25px;
background:#334155;
border-radius:15px;
margin-top:20px;
">

<p>
No rooms assigned yet.
Please contact electrician.
</p>

</div>

<?php endif; ?>

</div>

</div>

</body>
</html>
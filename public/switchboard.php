<?php

require_once '../includes/auth.php';
require_once '../config/db.php';

$room_id = $_GET['room_id'];

if(isset($_POST['switch_name'])){

    $switch_name = trim($_POST['switch_name']);

    $switch_type = $_POST['switch_type'];

    if($switch_name != ""){

        $stmt = $conn->prepare(

        "INSERT INTO switches
        (room_id,switch_name,switch_type)
        VALUES(?,?,?)"

        );

        $stmt->bind_param(
        "iss",
        $room_id,
        $switch_name,
        $switch_type
        );

        $stmt->execute();

    }

}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    $delete_stmt = $conn->prepare(

    "DELETE FROM switches
     WHERE id=?"

    );

    $delete_stmt->bind_param("i", $delete_id);

    $delete_stmt->execute();

    header(
    "Location: switchboard.php?room_id=$room_id"
    );

    exit;

}

$switches_stmt = $conn->prepare(

"SELECT * FROM switches
 WHERE room_id=?
 ORDER BY created_at ASC"

);

$switches_stmt->bind_param("i", $room_id);

$switches_stmt->execute();

$switches = $switches_stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Smart Switchboard
</title>

<link rel="stylesheet"
href="../assets/style.css">

<script src=
"https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js">
</script>

<style>

.switchboard-container{

display:flex;
justify-content:center;
align-items:center;

margin-top:40px;

}

.switchboard{

width:900px;
min-height:520px;

background:#e5e7eb;

border-radius:20px;

padding:30px;

display:flex;
flex-wrap:wrap;
gap:25px;

justify-content:flex-start;
align-content:flex-start;

box-shadow:
0 10px 25px rgba(0,0,0,0.35);

border:10px solid #cbd5e1;

}

.real-switch{

width:130px;
height:190px;

background:white;

border-radius:15px;

box-shadow:
0 6px 16px rgba(0,0,0,0.25);

display:flex;
flex-direction:column;
align-items:center;
justify-content:flex-start;

padding:15px;

cursor:move;

position:relative;

transition:0.3s;

}

.real-switch:hover{

transform:scale(1.03);

}

.switch-btn{

width:48px;
height:95px;

background:#d1d5db;

border-radius:12px;

cursor:pointer;

transition:0.3s;

margin-bottom:15px;

}

.switch-btn.active{

background:#22c55e;

box-shadow:
0 0 15px #22c55e;

}

.switch-icon{

font-size:28px;

margin-bottom:8px;

}

.switch-type{

font-size:20px;
font-weight:bold;

color:#0f172a;

}

.switch-name{

margin-top:5px;

font-size:14px;

color:#475569;

text-align:center;

word-break:break-word;

}

.delete-btn{

position:absolute;

top:10px;
right:10px;

background:red;

color:white;

border:none;

width:25px;
height:25px;

border-radius:50%;

font-size:14px;

cursor:pointer;

}

.form-area{

display:flex;
gap:15px;

margin-bottom:25px;

}

.form-area input{

flex:2;

}

.form-area select{

flex:1;

}

.form-area button{

flex:1;

}

</style>

</head>

<body>

<div class="navbar">

<h2>
SmartGruh
</h2>

<div>

<a href="javascript:history.back()">
Back
</a>

<a href="../actions/logout.php">
Logout
</a>

</div>

</div>

<div class="dashboard">

<h1>
Real Smart Switchboard
</h1>

<div class="card">

<form method="POST"
class="form-area">

<input type="text"
name="switch_name"
placeholder="Enter Switch Name"
required>

<select name="switch_type"
required>

<option value="">
Select Type
</option>

<option value="fan">
Fan
</option>

<option value="light">
Light
</option>

<option value="tv">
TV
</option>

<option value="ac">
AC
</option>

</select>

<button type="submit">
Add Switch
</button>

</form>

<div class="switchboard-container">

<div class="switchboard">

<?php

while($switch = $switches->fetch_assoc()) {

$icon = "💡";

if($switch['switch_type'] == 'fan'){
    $icon = "🌀";
}
elseif($switch['switch_type'] == 'tv'){
    $icon = "📺";
}
elseif($switch['switch_type'] == 'ac'){
    $icon = "❄️";
}

?>

<div class="real-switch">

<a href="switchboard.php?room_id=<?php echo $room_id; ?>&delete=<?php echo $switch['id']; ?>">

<button class="delete-btn">

X

</button>

</a>

<div
class="switch-btn"
onclick="toggleSwitch(this)">
</div>

<div class="switch-icon">

<?php echo $icon; ?>

</div>

<div class="switch-type">

<?php echo strtoupper($switch['switch_type']); ?>

</div>

<div class="switch-name">

<?php echo $switch['switch_name']; ?>

</div>

</div>

<?php } ?>

</div>

</div>

</div>

</div>

<script>

interact('.real-switch').draggable({

listeners: {

move(event) {

const target = event.target;

const x =
(parseFloat(
target.getAttribute('data-x')
) || 0)
+ event.dx;

const y =
(parseFloat(
target.getAttribute('data-y')
) || 0)
+ event.dy;

target.style.transform =
`translate(${x}px, ${y}px)`;

target.setAttribute('data-x', x);

target.setAttribute('data-y', y);

}

}

});

function toggleSwitch(element){

element.classList.toggle('active');

}

</script>

</body>
</html>
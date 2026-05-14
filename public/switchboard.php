<?php

require_once '../includes/auth.php';
require_once '../config/db.php';

if(!isset($_GET['room_id'])){
    die("Room ID Missing");
}

$room_id = $_GET['room_id'];

$room_stmt = $conn->prepare(
"SELECT * FROM rooms WHERE id=?"
);

$room_stmt->bind_param(
"i",
$room_id
);

$room_stmt->execute();

$room = $room_stmt
->get_result()
->fetch_assoc();

if(!$room){
    die("Room not found");
}

$owner_id = $room['user_id'];

if(isset($_POST['switch_name'])){

    $switch_name =
    trim($_POST['switch_name']);

    $switch_type =
    $_POST['switch_type'];

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

        header(
        "Location: switchboard.php?room_id=$room_id"
        );

        exit;

    }

}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    $delete_stmt = $conn->prepare(

    "DELETE FROM switches
     WHERE id=?"

    );

    $delete_stmt->bind_param(
    "i",
    $delete_id
    );

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

$switches_stmt->bind_param(
"i",
$room_id
);

$switches_stmt->execute();

$switches =
$switches_stmt->get_result();

$back_link =
($_SESSION['role'] == 'electrician')
? "manage_room.php?user_id=$owner_id"
: "user_dashboard.php";

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

width:980px;

min-height:600px;

background:linear-gradient(
180deg,
#f8fafc,
#e2e8f0
);

border-radius:35px;

padding:40px;

display:flex;
flex-wrap:wrap;
gap:35px;

align-content:flex-start;

box-shadow:
0 20px 50px rgba(0,0,0,0.45);

border:14px solid #cbd5e1;

position:relative;

overflow:hidden;

}

.switchboard::before{

content:"";

position:absolute;

top:0;
left:0;
right:0;
bottom:0;

border-radius:25px;

box-shadow:
inset 0 6px 16px rgba(255,255,255,0.9),
inset 0 -6px 16px rgba(0,0,0,0.08);

pointer-events:none;

}

.real-switch{

width:150px;

height:240px;

background:linear-gradient(
180deg,
#ffffff,
#f1f5f9
);

border-radius:24px;

display:flex;
flex-direction:column;
align-items:center;

padding:18px;

position:relative;

cursor:move;

transition:0.3s;

border:1px solid #dbeafe;

box-shadow:
0 10px 20px rgba(0,0,0,0.18);

}

.real-switch:hover{

transform:
translateY(-8px)
scale(1.03);

box-shadow:
0 16px 30px rgba(0,0,0,0.28);

}

.switch-btn{

width:60px;

height:110px;

border-radius:18px;

background:linear-gradient(
180deg,
#d1d5db,
#9ca3af
);

position:relative;

cursor:pointer;

transition:0.3s;

margin-bottom:18px;

box-shadow:
inset 0 5px 10px rgba(255,255,255,0.8),
inset 0 -5px 10px rgba(0,0,0,0.15),
0 4px 8px rgba(0,0,0,0.18);

}

.switch-btn::before{

content:"";

position:absolute;

top:12px;
left:50%;

transform:translateX(-50%);

width:28px;
height:8px;

background:rgba(255,255,255,0.7);

border-radius:10px;

}

.switch-btn.active{

background:linear-gradient(
180deg,
#22c55e,
#15803d
);

box-shadow:
0 0 18px rgba(34,197,94,0.8),
inset 0 4px 10px rgba(255,255,255,0.35);

}

.switch-icon{

width:78px;
height:78px;

display:flex;
align-items:center;
justify-content:center;

font-size:44px;

border-radius:22px;

background:linear-gradient(
180deg,
#ffffff,
#e2e8f0
);

margin-bottom:14px;

box-shadow:
inset 0 4px 10px rgba(255,255,255,0.9),
inset 0 -4px 10px rgba(0,0,0,0.08),
0 4px 10px rgba(0,0,0,0.08);

}

.switch-type{

font-size:26px;

font-weight:800;

color:#0f172a;

letter-spacing:1px;

margin-bottom:8px;

}

.switch-name{

font-size:15px;

color:#475569;

text-align:center;

line-height:22px;

word-break:break-word;

}

.delete-btn{

position:absolute;

top:10px;
right:10px;

width:30px;
height:30px;

border:none;

border-radius:50%;

background:#ef4444;

color:white;

font-size:16px;

font-weight:bold;

display:flex;
align-items:center;
justify-content:center;

cursor:pointer;

transition:0.2s;

box-shadow:
0 4px 10px rgba(0,0,0,0.2);

}

.delete-btn:hover{

background:#dc2626;

transform:scale(1.1);

}

.form-area{

display:flex;

gap:15px;

margin-bottom:35px;

}

.form-area input{

flex:2;

height:58px;

padding:0 20px;

border:none;

border-radius:16px;

background:#1e293b;

color:white;

font-size:16px;

outline:none;

}

.form-area select{

flex:1;

height:58px;

padding:0 15px;

border:none;

border-radius:16px;

background:#1e293b;

color:white;

font-size:16px;

outline:none;

}

.form-area button{

flex:1;

height:58px;

font-size:16px;

font-weight:bold;

border-radius:16px;

}

@media(max-width:1000px){

.switchboard{

width:100%;

justify-content:center;

padding:25px;

}

.real-switch{

width:135px;
height:225px;

}

}

</style>

</head>

<body>

<div class="navbar">

<h2>
SmartGruh
</h2>

<div>

<a href="<?php echo $back_link; ?>">
Back
</a>

<a href="../actions/logout.php">
Logout
</a>

</div>

</div>

<div class="dashboard">

<h1>

<?php echo ucfirst($room['room_name']); ?>

Switchboard

</h1>

<?php if($_SESSION['role'] == 'electrician'): ?>

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

</div>

<?php endif; ?>

<div class="switchboard-container">

<div class="switchboard">

<?php

while($switch =
$switches->fetch_assoc()) {

$icon = "💡";

if($switch['switch_type'] == 'fan'){
    $icon = "🪭";
}
elseif($switch['switch_type'] == 'tv'){
    $icon = "📺";
}
elseif($switch['switch_type'] == 'ac'){
    $icon = "❄️";
}
elseif($switch['switch_type'] == 'light'){
    $icon = "💡";
}

$active_class =
($switch['status'] == 'ON')
? 'active'
: '';

?>

<div class="real-switch">

<?php if($_SESSION['role']
== 'electrician'): ?>

<a href="switchboard.php?room_id=<?php echo $room_id; ?>&delete=<?php echo $switch['id']; ?>">

<button class="delete-btn">

×

</button>

</a>

<?php endif; ?>

<div
class="switch-btn <?php echo $active_class; ?>"
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
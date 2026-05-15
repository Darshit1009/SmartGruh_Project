<?php
require_once '../includes/auth.php';

if ($_SESSION['role'] !== 'admin') {
    if ($_SESSION['role'] === 'electrician') {
        header("Location: electrician_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Dashboard</title>

<link rel="stylesheet"
href="../assets/style.css">

</head>

<body>

<div class="dashboard">

<h1>
Admin Dashboard
</h1>

<h2>
Welcome
<?php echo $_SESSION['name']; ?>
</h2>

<div class="card">

<h3>
Admin Controls
</h3>

<p>
Manage all users and devices.
</p>

</div>

<a href="../actions/logout.php">
<button>
Logout
</button>
</a>

</div>

</body>
</html>
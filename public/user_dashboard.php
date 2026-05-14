<?php
require_once '../includes/auth.php';
?>

<!DOCTYPE html>
<html>

<head>

<title>User Dashboard</title>

<link rel="stylesheet"
href="../assets/style.css">

</head>

<body>

<div class="dashboard">

<h1>
User Dashboard
</h1>

<h2>
Welcome
<?php echo $_SESSION['name']; ?>
</h2>

<div class="card">

<h3>
SmartGruh User Panel
</h3>

<p>
Home automation access granted.
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
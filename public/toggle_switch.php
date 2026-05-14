<?php

require_once '../config/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare(

"SELECT * FROM switches
 WHERE id=?"

);

$stmt->bind_param("i", $id);

$stmt->execute();

$get = $stmt->get_result();

$switch = $get->fetch_assoc();

$new_status =
($switch['status'] == 'ON')
? 'OFF'
: 'ON';

$update_stmt = $conn->prepare(

"UPDATE switches
 SET status=?
 WHERE id=?"

);

$update_stmt->bind_param("si", $new_status, $id);

$update_stmt->execute();

echo "done";

?>
<?php

session_start();

require_once '../vendor/autoload.php';
require_once '../config/db.php';
require_once '../config/mqtt.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);

    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        "success" => false,
        "message" => "Invalid Request"
    ]);

    exit;
}

$switch_id = isset($_POST['switch_id']) ? intval($_POST['switch_id']) : 0;
$state = isset($_POST['state']) ? $_POST['state'] : 'OFF';

if ($switch_id <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid Switch ID"
    ]);
    exit;
}

try {
    // Update database
    $stmt = $conn->prepare("UPDATE switches SET status=? WHERE id=?");
    $stmt->bind_param("si", $state, $switch_id);
    $stmt->execute();

    echo json_encode([
        "success" => true,
        "message" => "Status updated in Database",
        "state" => $state
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
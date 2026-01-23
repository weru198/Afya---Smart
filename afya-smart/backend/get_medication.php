<?php
include "db.php";

if (!isset($_SESSION['user_id'])) {
    exit;
}

$user_id = $_SESSION['user_id'];

$result = $conn->query(
    "SELECT * FROM medications WHERE user_id = $user_id ORDER BY reminder_time"
);

$meds = [];
while ($row = $result->fetch_assoc()) {
    $meds[] = $row;
}

echo json_encode($meds);

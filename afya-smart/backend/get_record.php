<?php
include "db.php";

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM health_records WHERE user_id=$user_id");

$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

echo json_encode($records);
?>

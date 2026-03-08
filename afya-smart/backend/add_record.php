<?php
include "db.php";

$user_id = $_SESSION['user_id'];
$type = $_POST['type'];
$desc = $_POST['description'];
$date = $_POST['date'];

$sql = "INSERT INTO health_records (user_id, record_type, description, record_date)
        VALUES ('$user_id', '$type', '$desc', '$date')";

$conn->query($sql);
?>

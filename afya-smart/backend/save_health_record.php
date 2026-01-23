<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

$user_id = $_SESSION['user_id'];
$type = $_POST['recordType'];
$description = $_POST['description'];
$date = $_POST['recordDate'];

$stmt = $conn->prepare(
    "INSERT INTO health_records (user_id, record_type, description, record_date)
     VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("isss", $user_id, $type, $description, $date);
$stmt->execute();

header("Location: ../health-records.php");
exit;

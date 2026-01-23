<?php
include "db.php";

if (!isset($_SESSION['user_id'])) {
    exit;
}

$user_id = $_SESSION['user_id'];
$medicine = $_POST['medicine'];
$dosage = $_POST['dosage'];
$time = $_POST['time'];

$sql = "INSERT INTO medications (user_id, medicine_name, dosage, reminder_time)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $user_id, $medicine, $dosage, $time);
$stmt->execute();

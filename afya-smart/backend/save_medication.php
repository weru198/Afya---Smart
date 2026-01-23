<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

$user_id = $_SESSION['user_id'];
$medicine = $_POST['medicine'];
$dosage = $_POST['dosage'];
$time = $_POST['time'];

$stmt = $conn->prepare(
    "INSERT INTO medication (user_id, medicine, dosage, reminder_time)
     VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("isss", $user_id, $medicine, $dosage, $time);
$stmt->execute();

echo "Saved";

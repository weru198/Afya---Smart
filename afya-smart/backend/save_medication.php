<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$medicine = trim($_POST['medicine'] ?? '');
$dosage = trim($_POST['dosage'] ?? '');
$time = trim($_POST['time'] ?? '');

if ($medicine === '' || $dosage === '' || $time === '') {
    header("Location: ../medication.php?status=error");
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO medication (user_id, medicine, dosage, reminder_time)
     VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("isss", $user_id, $medicine, $dosage, $time);
$ok = $stmt->execute();

header("Location: ../medication.php?status=" . ($ok ? "saved" : "error"));
exit;

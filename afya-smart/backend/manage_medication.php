<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$id = (int) ($_POST['id'] ?? 0);
$action = $_POST['action'] ?? '';

if ($id <= 0) {
    header("Location: ../medication.php?status=error");
    exit;
}

if ($action === 'update') {
    $medicine = trim($_POST['medicine'] ?? '');
    $dosage = trim($_POST['dosage'] ?? '');
    $time = trim($_POST['time'] ?? '');

    if ($medicine === '' || $dosage === '' || $time === '') {
        header("Location: ../medication.php?status=error");
        exit;
    }

    $stmt = $conn->prepare(
        "UPDATE medication
         SET medicine = ?, dosage = ?, reminder_time = ?
         WHERE id = ? AND user_id = ?"
    );
    $stmt->bind_param("sssii", $medicine, $dosage, $time, $id, $user_id);
    $ok = $stmt->execute();

    header("Location: ../medication.php?status=" . ($ok ? "updated" : "error"));
    exit;
}

if ($action === 'delete') {
    $stmt = $conn->prepare("DELETE FROM medication WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $ok = $stmt->execute();

    header("Location: ../medication.php?status=" . ($ok ? "deleted" : "error"));
    exit;
}

header("Location: ../medication.php?status=error");
exit;

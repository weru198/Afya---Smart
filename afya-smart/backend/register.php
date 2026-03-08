<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../register.html");
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password_raw = $_POST['password'] ?? '';

if ($name === '' || $email === '' || $password_raw === '') {
    header("Location: ../register.html?status=missing");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../register.html?status=invalid_email");
    exit;
}

if (strlen($password_raw) < 6) {
    header("Location: ../register.html?status=weak_password");
    exit;
}

$check = $conn->prepare("SELECT user_id FROM users WHERE email = ? LIMIT 1");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    header("Location: ../register.html?status=email_exists");
    exit;
}

$password = password_hash($password_raw, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
    header("Location: ../login.html?status=registered");
    exit;
}

header("Location: ../register.html?status=error");
exit;

<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.html");
    exit;
}

$email = trim($_POST["email"] ?? '');
$password = $_POST["password"] ?? '';

if ($email === '' || $password === '') {
    header("Location: ../login.html?status=missing");
    exit;
}

$stmt = $conn->prepare(
    "SELECT user_id, full_name, password FROM users WHERE email = ? LIMIT 1"
);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result ? $result->fetch_assoc() : null;

if ($user && password_verify($password, $user["password"])) {
    $_SESSION["user_id"] = $user["user_id"];
    $_SESSION["full_name"] = $user["full_name"];

    header("Location: ../dashboard.php");
    exit;
}

header("Location: ../login.html?status=invalid");
exit;

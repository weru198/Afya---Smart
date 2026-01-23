<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.html");
    exit;
}

$email = $_POST["email"];
$password = $_POST["password"];

$stmt = $conn->prepare(
    "SELECT user_id, full_name, password FROM users WHERE email = ?"
);
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($password, $user["password"])) {
    $_SESSION["user_id"] = $user["user_id"];
    $_SESSION["full_name"] = $user["full_name"];

    header("Location: ../dashboard.php");
    exit;
}

header("Location: ../login.html");
exit;

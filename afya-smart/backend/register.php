<?php
include "db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$conn->query("INSERT INTO users (full_name, email, password)
              VALUES ('$name', '$email', '$password')");

header("Location: ../login.html");
?>

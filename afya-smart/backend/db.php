<?php
$conn = new mysqli("localhost", "root", "", "afya_smart");

if ($conn->connect_error) {
    die("Database connection failed");
}

?>

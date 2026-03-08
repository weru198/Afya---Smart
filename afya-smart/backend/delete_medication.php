<?php
include "db.php";

if (!isset($_SESSION['user_id'])) {
    exit;
}

$id = $_POST['id'];
$user_id = $_SESSION['user_id'];

$conn->query(
    "DELETE FROM medications 
     WHERE medication_id = $id AND user_id = $user_id"
);

<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "Unauthorized";
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$mood = trim($_POST['mood'] ?? '');

$allowed = ['happy', 'stressed', 'sad', 'anxious', 'tired'];
if (!in_array($mood, $allowed, true)) {
    http_response_code(400);
    echo "Invalid mood";
    exit;
}

$conn->query(
    "CREATE TABLE IF NOT EXISTS mood_checkins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        mood VARCHAR(30) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX (user_id),
        CONSTRAINT fk_mood_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
    )"
);

$stmt = $conn->prepare("INSERT INTO mood_checkins (user_id, mood) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $mood);
$ok = $stmt->execute();

header('Content-Type: application/json');
echo json_encode(['ok' => $ok]);

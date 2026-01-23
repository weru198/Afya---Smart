<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | AfyaSmart</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">AfyaSmart</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="medication.php">Medication</a></li>
                <li class="nav-item"><a class="nav-link" href="mental-health.php">Mental Health</a></li>
                <li class="nav-item"><a class="nav-link" href="diet.php">Diet & Wellness</a></li>
                <li class="nav-item"><a class="nav-link" href="health-records.php">Health Records</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="backend/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<section class="container my-5">
    <h2 class="text-center text-success mb-4">User Dashboard</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow h-100 text-center p-4">
                <h5>💊 Medication Reminder</h5>
                <p>Schedule and manage your medication reminders.</p>
                <a href="medication.php" class="btn btn-success">Open</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow h-100 text-center p-4">
                <h5>🧠 Mental Health Companion</h5>
                <p>Check in with your emotions and get wellness support.</p>
                <a href="mental-health.php" class="btn btn-success">Open</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow h-100 text-center p-4">
                <h5>🥗 Diet & Wellness Planner</h5>
                <p>Get personalized diet and lifestyle tips.</p>
                <a href="diet.php" class="btn btn-success">Open</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow h-100 text-center p-4">
                <h5>📁 Health Records</h5>
                <p>View and manage your personal health records.</p>
                <a href="health-records.php" class="btn btn-success">Open</a>
            </div>
        </div>
    </div>
</section>

<footer class="bg-success text-white text-center p-3">
    <p class="mb-0">AfyaSmart Dashboard | Student Healthcare System</p>
</footer>

</body>
</html>

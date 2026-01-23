<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medication Reminder | AfyaSmart</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">AfyaSmart</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#authNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="authNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="medication.php">
                        <i class="bi bi-capsule me-1"></i> Medication
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="mental-health.php">
                        <i class="bi bi-heart-pulse me-1"></i> Mental Health
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="diet.php">
                        <i class="bi bi-egg-fried me-1"></i> Diet & Wellness
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="health-records.php">
                        <i class="bi bi-folder2-open me-1"></i> Health Records
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-danger" href="backend/logout.php">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Medication Reminder -->
<section class="container my-5">
    <h2 class="text-center text-success mb-4">Medication Reminder</h2>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">

                <!-- 🔥 UPDATED FORM -->
                <form method="POST" action="backend/save_medication.php">
                    <div class="mb-3">
                        <label class="form-label">Medicine Name</label>
                        <input type="text"
                               name="medicine"
                               class="form-control"
                               placeholder="e.g. Paracetamol"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dosage</label>
                        <input type="text"
                               name="dosage"
                               class="form-control"
                               placeholder="e.g. 2 tablets"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reminder Time</label>
                        <input type="time"
                               name="time"
                               class="form-control"
                               required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        Save Reminder
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Reminder List (optional display later) -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <h4 class="text-center mb-3">Saved Reminders</h4>
            <ul class="list-group" id="reminderList"></ul>
        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

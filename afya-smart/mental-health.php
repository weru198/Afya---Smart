<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Health Companion | AfyaSmart</title>

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
                    <a class="nav-link" href="medication.php">
                        <i class="bi bi-capsule me-1"></i> Medication
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="mental-health.php">
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

<!-- Mental Health Section -->
<section class="container my-5">
    <h2 class="text-center text-success mb-4">Mental Health Companion</h2>
    <p class="text-center mb-4">
        Select how you are feeling and receive supportive wellness guidance.
    </p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">

                <label class="fw-semibold mb-2">How are you feeling today?</label>

                <select id="mood" class="form-select mb-3">
                    <option value="">-- Select Mood --</option>
                    <option value="happy">😊 Happy</option>
                    <option value="stressed">😣 Stressed</option>
                    <option value="sad">😢 Sad</option>
                    <option value="anxious">😰 Anxious</option>
                    <option value="tired">😴 Tired</option>
                </select>

                <button id="moodBtn" class="btn btn-success w-100">
                    <i class="bi bi-chat-dots me-1"></i> Get Support
                </button>

                <div id="response"
                     class="alert alert-success mt-4 d-none"
                     style="white-space: pre-line;">
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-success text-white text-center p-3">
    <p class="mb-0">
        This tool provides general emotional support and does not replace professional care.
    </p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="js/main.js"></script>

</body>
</html>

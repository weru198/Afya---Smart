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
    <title>Diet & Wellness Planner | AfyaSmart</title>

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
                    <a class="nav-link" href="mental-health.php">
                        <i class="bi bi-heart-pulse me-1"></i> Mental Health
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="diet.php">
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

<!-- Diet & Wellness Section -->
<section class="container my-5">
    <h2 class="text-center text-success mb-4">Diet & Wellness Planner</h2>
    <p class="text-center mb-4">
        Get simple diet and wellness recommendations based on your lifestyle.
    </p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4">

                <form id="dietForm">
                    <div class="mb-3">
                        <label class="form-label">Diet Preference</label>
                        <select id="diet" class="form-select" required>
                            <option value="">-- Select --</option>
                            <option value="balanced">Balanced</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="high-protein">High Protein</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Activity Level</label>
                        <select id="activity" class="form-select" required>
                            <option value="">-- Select --</option>
                            <option value="low">Low</option>
                            <option value="moderate">Moderate</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Wellness Goal</label>
                        <select id="goal" class="form-select" required>
                            <option value="">-- Select --</option>
                            <option value="weight">Weight Management</option>
                            <option value="energy">Improve Energy</option>
                            <option value="stress">Reduce Stress</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        Generate Plan
                    </button>
                </form>

                <div id="dietResult" class="alert alert-info d-none mt-4" style="white-space: pre-line;"></div>

            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-success text-white text-center p-3">
    <p class="mb-0">
        Recommendations are general wellness guidance and not medical advice.
    </p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="js/main.js"></script>

</body>
</html>

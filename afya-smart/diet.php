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
    <meta name="description" content="Generate personalized diet and wellness recommendations in AfyaSmart.">
    <meta name="theme-color" content="#0b5f49">
    <meta property="og:title" content="AfyaSmart">
    <meta property="og:description" content="Generate personalized diet and wellness recommendations in AfyaSmart.">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <title>Diet & Wellness Planner | AfyaSmart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="app-body page-app">
<nav class="navbar navbar-expand-lg navbar-dark glass-nav">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><span class="brand-mark"><i class="bi bi-plus-lg"></i></span><span>AfyaSmart</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#authNav" aria-controls="authNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="authNav">
            <ul class="navbar-nav ms-auto gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="medication.php">Medication</a></li>
                <li class="nav-item"><a class="nav-link" href="mental-health.php">Mental Health</a></li>
                <li class="nav-item"><a class="nav-link active" href="diet.php">Diet & Wellness</a></li>
                <li class="nav-item"><a class="nav-link" href="health-records.php">Health Records</a></li>
                <li class="nav-item"><a class="nav-link" href="emergency.html">Emergency</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="backend/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="main-wrap">
    <div class="page-shell">
        <section class="app-hero reveal-up module-hero">
            <div>
                <p class="app-hero-kicker">Diet & Wellness Module</p>
                <h2>Build a practical wellness plan</h2>
                <p>Choose your preferences and generate an action-oriented plan tailored to your daily routine.</p>
            </div>
            <div class="app-hero-badge">
                <i class="bi bi-egg-fried"></i>
                <strong>Smart Plan Builder</strong>
                <span>Quick inputs with readable guidance output.</span>
            </div>
        </section>

        <section class="content-grid reveal-up" style="animation-delay:.1s;">
            <article class="panel">
                <div class="panel-title-row">
                    <h4>Plan Generator</h4>
                    <span>Personalized</span>
                </div>
                <form id="dietForm">
                    <div class="mb-3">
                        <label class="form-label">Diet Preference</label>
                        <select id="diet" class="form-select" required>
                            <option value="">Select</option>
                            <option value="balanced">Balanced</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="high-protein">High Protein</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Activity Level</label>
                        <select id="activity" class="form-select" required>
                            <option value="">Select</option>
                            <option value="low">Low</option>
                            <option value="moderate">Moderate</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Wellness Goal</label>
                        <select id="goal" class="form-select" required>
                            <option value="">Select</option>
                            <option value="weight">Weight Management</option>
                            <option value="energy">Improve Energy</option>
                            <option value="stress">Reduce Stress</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-magic"></i>Generate Plan</button>
                </form>

                <div id="dietResult" class="alert alert-info d-none mt-4" style="white-space: pre-line;"></div>
            </article>

            <aside class="panel">
                <div class="panel-title-row">
                    <h4>Wellness Checklist</h4>
                    <span>Daily</span>
                </div>
                <div class="quick-list">
                    <div class="quick-item"><span>Hydration target</span><strong>Track</strong></div>
                    <div class="quick-item"><span>Meal balance</span><strong>Monitor</strong></div>
                    <div class="quick-item"><span>Movement session</span><strong>Plan</strong></div>
                    <div class="quick-item"><span>Sleep consistency</span><strong>Protect</strong></div>
                </div>
            </aside>
        </section>
    </div>
</main>

<footer class="site-footer">
    <p class="mb-0">General wellness recommendations only.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>





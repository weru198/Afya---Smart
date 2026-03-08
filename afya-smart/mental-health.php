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
    <meta name="description" content="Use AfyaSmart mental wellness tools for mood check-ins and support guidance.">
    <meta name="theme-color" content="#0b5f49">
    <meta property="og:title" content="AfyaSmart">
    <meta property="og:description" content="Use AfyaSmart mental wellness tools for mood check-ins and support guidance.">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <title>Mental Health Companion | AfyaSmart</title>
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
                <li class="nav-item"><a class="nav-link active" href="mental-health.php">Mental Health</a></li>
                <li class="nav-item"><a class="nav-link" href="diet.php">Diet & Wellness</a></li>
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
                <p class="app-hero-kicker">Mental Wellness Module</p>
                <h2>Check in and get support prompts</h2>
                <p>Select your mood and receive quick guidance to help stabilize your day.</p>
            </div>
            <div class="app-hero-badge">
                <i class="bi bi-heart-pulse"></i>
                <strong>Guided Check-in</strong>
                <span>Simple prompts, immediate response.</span>
            </div>
        </section>

        <section class="content-grid reveal-up" style="animation-delay:.1s;">
            <article class="panel">
                <div class="panel-title-row">
                    <h4>Mood Input</h4>
                    <span>Interactive</span>
                </div>
                <label class="form-label mb-2">How are you feeling today?</label>
                <select id="mood" class="form-select mb-3">
                    <option value="">Select mood</option>
                    <option value="happy">Happy</option>
                    <option value="stressed">Stressed</option>
                    <option value="sad">Sad</option>
                    <option value="anxious">Anxious</option>
                    <option value="tired">Tired</option>
                </select>

                <button id="moodBtn" class="btn btn-success w-100"><i class="bi bi-chat-dots"></i>Get Support</button>
                <div id="response" class="alert alert-success mt-4 d-none" style="white-space: pre-line;"></div>
            </article>

            <aside class="panel">
                <div class="panel-title-row">
                    <h4>Wellness Notes</h4>
                    <span>Daily</span>
                </div>
                <div class="quick-list">
                    <div class="quick-item"><span>Breathe for 2 minutes</span><strong>Now</strong></div>
                    <div class="quick-item"><span>Take a short walk</span><strong>Suggested</strong></div>
                    <div class="quick-item"><span>Hydrate and rest</span><strong>Essential</strong></div>
                    <div class="quick-item"><span>Reach out if overwhelmed</span><strong>Priority</strong></div>
                </div>
            </aside>
        </section>
    </div>
</main>

<footer class="site-footer">
    <p class="mb-0">General support guidance only. Not a replacement for medical professionals.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>





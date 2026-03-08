<?php
session_start();
include "backend/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$display_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Student';

$medication_count = 0;
$record_count = 0;
$next_reminder = null;
$latest_mood = null;
$due_reminders = [];

if ($stmt = $conn->prepare("SELECT COUNT(*) FROM medication WHERE user_id = ?")) {
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $stmt->bind_result($med_count_db);
        if ($stmt->fetch()) {
            $medication_count = (int) $med_count_db;
        }
    }
    $stmt->close();
}

if ($stmt = $conn->prepare("SELECT COUNT(*) FROM health_records WHERE user_id = ?")) {
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $stmt->bind_result($record_count_db);
        if ($stmt->fetch()) {
            $record_count = (int) $record_count_db;
        }
    }
    $stmt->close();
}

if ($stmt = $conn->prepare(
    "SELECT medicine, dosage, reminder_time
     FROM medication
     WHERE user_id = ?
     ORDER BY (reminder_time < CURTIME()), reminder_time
     LIMIT 1"
)) {
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $stmt->bind_result($next_medicine, $next_dosage, $next_time);
        if ($stmt->fetch()) {
            $next_reminder = [
                'medicine' => $next_medicine,
                'dosage' => $next_dosage,
                'reminder_time' => $next_time
            ];
        }
    }
    $stmt->close();
}

$has_mood_table = false;
if ($res = $conn->query("SHOW TABLES LIKE 'mood_checkins'")) {
    $has_mood_table = $res->num_rows > 0;
    $res->free();
}

if ($has_mood_table && ($stmt = $conn->prepare(
    "SELECT mood, created_at
     FROM mood_checkins
     WHERE user_id = ?
     ORDER BY created_at DESC
     LIMIT 1"
))) {
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $stmt->bind_result($latest_mood_name, $latest_mood_at);
        if ($stmt->fetch()) {
            $latest_mood = [
                'mood' => $latest_mood_name,
                'created_at' => $latest_mood_at
            ];
        }
    }
    $stmt->close();
}

$now = date('H:i:s');
$plus = date('H:i:s', strtotime('+60 minutes'));

if ($plus >= $now) {
    $stmt = $conn->prepare(
        "SELECT medicine, reminder_time
         FROM medication
         WHERE user_id = ? AND reminder_time BETWEEN ? AND ?
         ORDER BY reminder_time"
    );
    if ($stmt) {
        $stmt->bind_param("iss", $user_id, $now, $plus);
    }
} else {
    $stmt = $conn->prepare(
        "SELECT medicine, reminder_time
         FROM medication
         WHERE user_id = ? AND (reminder_time >= ? OR reminder_time <= ?)
         ORDER BY reminder_time"
    );
    if ($stmt) {
        $stmt->bind_param("iss", $user_id, $now, $plus);
    }
}

if ($stmt && $stmt->execute()) {
    $stmt->bind_result($due_medicine, $due_time);
    while ($stmt->fetch()) {
        $due_reminders[] = [
            'medicine' => $due_medicine,
            'reminder_time' => $due_time
        ];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AfyaSmart dashboard with live medication, records, mood, and emergency tools.">
    <meta name="theme-color" content="#0b5f49">
    <meta property="og:title" content="AfyaSmart">
    <meta property="og:description" content="AfyaSmart dashboard with live medication, records, mood, and emergency tools.">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <title>Dashboard | AfyaSmart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="app-body page-app">
<nav class="navbar navbar-expand-lg navbar-dark glass-nav">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><span class="brand-mark"><i class="bi bi-plus-lg"></i></span><span>AfyaSmart</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#authNav" aria-controls="authNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="authNav">
            <ul class="navbar-nav ms-auto gap-lg-2">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="medication.php">Medication</a></li>
                <li class="nav-item"><a class="nav-link" href="mental-health.php">Mental Health</a></li>
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
        <?php if (count($due_reminders) > 0): ?>
        <div id="dueReminderBanner" class="alert alert-warning" data-count="<?= count($due_reminders) ?>">
            <strong>Due within 60 minutes:</strong>
            <?php foreach ($due_reminders as $idx => $rem): ?>
                <?= htmlspecialchars($rem['medicine']) ?> at <?= date('g:i A', strtotime($rem['reminder_time'])) ?><?= $idx < count($due_reminders) - 1 ? ', ' : '' ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <section class="app-hero reveal-up">
            <div>
                <p class="app-hero-kicker">Control Center</p>
                <h2>Welcome back, <?= htmlspecialchars($display_name) ?></h2>
                <p>Track your health routines, update records, and keep daily wellness actions consistent from one dashboard.</p>
                <div class="hero-actions mt-3">
                    <a href="medication.php" class="btn btn-success"><i class="bi bi-alarm"></i>Set Reminder</a>
                    <a href="health-records.php" class="btn btn-outline-success"><i class="bi bi-folder2-open"></i>Open Records</a>
                </div>
            </div>
            <div class="app-hero-badge">
                <i class="bi bi-shield-check"></i>
                <strong>Secure Session Active</strong>
                <span>Your account is signed in and protected.</span>
            </div>
        </section>

        <section class="metric-grid reveal-up" style="animation-delay:.08s;">
            <article class="metric-card">
                <span>Medication Entries</span>
                <strong><?= $medication_count ?></strong>
                <small>Live reminders in your schedule</small>
            </article>
            <article class="metric-card">
                <span>Health Records</span>
                <strong><?= $record_count ?></strong>
                <small>Stored personal medical entries</small>
            </article>
            <article class="metric-card">
                <span>Next Reminder</span>
                <strong><?= $next_reminder ? date('g:i A', strtotime($next_reminder['reminder_time'])) : 'None' ?></strong>
                <small><?= $next_reminder ? htmlspecialchars($next_reminder['medicine']) : 'Add a medication reminder' ?></small>
            </article>
            <article class="metric-card">
                <span>Last Mood Check</span>
                <strong><?= $latest_mood ? ucfirst(htmlspecialchars($latest_mood['mood'])) : 'No check-in' ?></strong>
                <small><?= $latest_mood ? date('M d, g:i A', strtotime($latest_mood['created_at'])) : 'Capture from Mental Health tab' ?></small>
            </article>
        </section>

        <section class="content-grid reveal-up" style="animation-delay:.14s;">
            <article class="panel">
                <div class="panel-title-row">
                    <h4>Platform Modules</h4>
                    <span>Quick launch</span>
                </div>

                <div class="module-grid">
                    <a class="module-card" href="medication.php">
                        <div class="module-icon"><i class="bi bi-capsule"></i></div>
                        <h5>Medication</h5>
                        <p>Save medicines, dosage, and reminder times.</p>
                    </a>
                    <a class="module-card" href="mental-health.php">
                        <div class="module-icon"><i class="bi bi-heart-pulse"></i></div>
                        <h5>Mental Health</h5>
                        <p>Check your mood and receive supportive prompts.</p>
                    </a>
                    <a class="module-card" href="diet.php">
                        <div class="module-icon"><i class="bi bi-egg-fried"></i></div>
                        <h5>Diet & Wellness</h5>
                        <p>Generate guidance from goals and activity level.</p>
                    </a>
                    <a class="module-card" href="health-records.php">
                        <div class="module-icon"><i class="bi bi-folder2-open"></i></div>
                        <h5>Health Records</h5>
                        <p>Capture and review medical entries securely.</p>
                    </a>
                    <a class="module-card" href="emergency.html">
                        <div class="module-icon"><i class="bi bi-exclamation-triangle"></i></div>
                        <h5>Emergency</h5>
                        <p>Access SOS actions, location details, and key contacts.</p>
                    </a>
                </div>
            </article>

            <aside class="panel">
                <div class="panel-title-row">
                    <h4>Today Focus</h4>
                    <span>Live status</span>
                </div>
                <div class="quick-list">
                    <div class="quick-item"><span>Due soon reminders</span><strong><?= count($due_reminders) ?></strong></div>
                    <div class="quick-item"><span>Total medications</span><strong><?= $medication_count ?></strong></div>
                    <div class="quick-item"><span>Stored records</span><strong><?= $record_count ?></strong></div>
                    <div class="quick-item"><span>Emergency tools</span><strong>Active</strong></div>
                </div>
            </aside>
        </section>
    </div>
</main>

<footer class="site-footer">
    <p class="mb-0">AfyaSmart dashboard experience.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>

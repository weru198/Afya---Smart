<?php
session_start();
include "backend/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$notice = isset($_GET['status']) ? $_GET['status'] : '';

$stmt = $conn->prepare(
    "SELECT id, medicine, dosage, reminder_time, created_at
     FROM medication
     WHERE user_id = ?
     ORDER BY reminder_time"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$medications = $stmt->get_result();

$due_reminders = [];
$now = date('H:i:s');
$plus = date('H:i:s', strtotime('+60 minutes'));
if ($plus >= $now) {
    $stmt = $conn->prepare(
        "SELECT medicine, reminder_time
         FROM medication
         WHERE user_id = ? AND reminder_time BETWEEN ? AND ?
         ORDER BY reminder_time"
    );
    $stmt->bind_param("iss", $user_id, $now, $plus);
} else {
    $stmt = $conn->prepare(
        "SELECT medicine, reminder_time
         FROM medication
         WHERE user_id = ? AND (reminder_time >= ? OR reminder_time <= ?)
         ORDER BY reminder_time"
    );
    $stmt->bind_param("iss", $user_id, $now, $plus);
}
$stmt->execute();
$due_result = $stmt->get_result();
while ($row = $due_result->fetch_assoc()) {
    $due_reminders[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manage medication reminders, dosage, and schedule details with AfyaSmart.">
    <meta name="theme-color" content="#0b5f49">
    <meta property="og:title" content="AfyaSmart">
    <meta property="og:description" content="Manage medication reminders, dosage, and schedule details with AfyaSmart.">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <title>Medication Reminder | AfyaSmart</title>
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
                <li class="nav-item"><a class="nav-link active" href="medication.php">Medication</a></li>
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
        <?php if ($notice === 'saved'): ?>
        <div class="alert alert-success">Medication reminder saved.</div>
        <?php elseif ($notice === 'updated'): ?>
        <div class="alert alert-success">Medication reminder updated.</div>
        <?php elseif ($notice === 'deleted'): ?>
        <div class="alert alert-success">Medication reminder deleted.</div>
        <?php elseif ($notice === 'error'): ?>
        <div class="alert alert-danger">Could not process medication action. Try again.</div>
        <?php endif; ?>

        <?php if (count($due_reminders) > 0): ?>
        <div id="dueReminderBanner" class="alert alert-warning" data-count="<?= count($due_reminders) ?>">
            <strong>Due within 60 minutes:</strong>
            <?php foreach ($due_reminders as $idx => $rem): ?>
                <?= htmlspecialchars($rem['medicine']) ?> at <?= date('g:i A', strtotime($rem['reminder_time'])) ?><?= $idx < count($due_reminders) - 1 ? ', ' : '' ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <section class="app-hero reveal-up module-hero">
            <div>
                <p class="app-hero-kicker">Medication Module</p>
                <h2>Set, edit, and remove medication reminders</h2>
                <p>This page now supports full CRUD so your reminder schedule stays accurate over time.</p>
            </div>
            <div class="app-hero-badge">
                <i class="bi bi-alarm"></i>
                <strong>Reminder Setup</strong>
                <span>Manage every reminder from a single screen.</span>
            </div>
        </section>

        <section class="record-layout reveal-up" style="animation-delay:.1s;">
            <article class="panel h-100">
                <div class="panel-title-row">
                    <h4>New Reminder</h4>
                    <span>Create</span>
                </div>
                <form method="POST" action="backend/save_medication.php">
                    <div class="mb-3">
                        <label class="form-label">Medicine Name</label>
                        <input type="text" name="medicine" class="form-control" placeholder="e.g. Paracetamol" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dosage</label>
                        <input type="text" name="dosage" class="form-control" placeholder="e.g. 2 tablets" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Reminder Time</label>
                        <input type="time" name="time" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-check2-circle"></i>Save Reminder</button>
                </form>
            </article>

            <article class="panel h-100">
                <div class="panel-title-row">
                    <h4>Saved Reminders</h4>
                    <span><?= $medications->num_rows ?> items</span>
                </div>

                <?php if ($medications->num_rows === 0): ?>
                    <p class="text-muted mb-0">No reminders yet. Add your first medication reminder.</p>
                <?php else: ?>
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Dosage</th>
                                        <th>Time</th>
                                        <th style="width: 220px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $medications->fetch_assoc()): ?>
                                    <tr>
                                        <form method="POST" action="backend/manage_medication.php">
                                            <td>
                                                <input type="text" name="medicine" class="form-control form-control-sm" value="<?= htmlspecialchars($row['medicine']) ?>" required>
                                            </td>
                                            <td>
                                                <input type="text" name="dosage" class="form-control form-control-sm" value="<?= htmlspecialchars($row['dosage']) ?>" required>
                                            </td>
                                            <td>
                                                <input type="time" name="time" class="form-control form-control-sm" value="<?= date('H:i', strtotime($row['reminder_time'])) ?>" required>
                                            </td>
                                            <td>
                                                <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                                                <div class="d-flex gap-2">
                                                    <button type="submit" name="action" value="update" class="btn btn-sm btn-success">Update</button>
                                                    <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger" onclick="return confirm('Delete this reminder?');">Delete</button>
                                                </div>
                                            </td>
                                        </form>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </article>
        </section>
    </div>
</main>

<footer class="site-footer">
    <p class="mb-0">AfyaSmart professional web experience.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>

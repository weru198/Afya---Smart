<?php
session_start();
include "backend/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$records = $conn->query(
    "SELECT * FROM health_records WHERE user_id=$user_id ORDER BY record_date DESC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Add and review your health records securely with AfyaSmart.">
    <meta name="theme-color" content="#0b5f49">
    <meta property="og:title" content="AfyaSmart">
    <meta property="og:description" content="Add and review your health records securely with AfyaSmart.">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <title>Health Records | AfyaSmart</title>
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
                <li class="nav-item"><a class="nav-link" href="diet.php">Diet & Wellness</a></li>
                <li class="nav-item"><a class="nav-link active" href="health-records.php">Health Records</a></li>
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
                <p class="app-hero-kicker">Health Records Module</p>
                <h2>Maintain a complete medical timeline</h2>
                <p>Add new health entries and review your records in a structured, searchable-ready format.</p>
            </div>
            <div class="app-hero-badge">
                <i class="bi bi-folder2-open"></i>
                <strong>Records Vault</strong>
                <span>Personal health history available in one view.</span>
            </div>
        </section>

        <section class="record-layout reveal-up" style="animation-delay:.1s;">
            <article class="panel h-100">
                <div class="panel-title-row">
                    <h4>Add Health Record</h4>
                    <span>Entry form</span>
                </div>
                <form method="POST" action="backend/save_health_record.php">
                    <div class="mb-3">
                        <label class="form-label">Record Type</label>
                        <select name="recordType" class="form-select" required>
                            <option value="">Select</option>
                            <option value="Allergy">Allergy</option>
                            <option value="Medication">Medication</option>
                            <option value="Condition">Medical Condition</option>
                            <option value="Vaccination">Vaccination</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Date</label>
                        <input type="date" name="recordDate" class="form-control" required>
                    </div>
                    <button class="btn btn-success w-100"><i class="bi bi-save2"></i>Save Record</button>
                </form>
            </article>

            <article class="panel h-100">
                <div class="panel-title-row">
                    <h4>My Records</h4>
                    <span><?= $records->num_rows ?> entries</span>
                </div>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $records->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['record_type']) ?></td>
                                    <td><?= htmlspecialchars($row['description']) ?></td>
                                    <td><?= htmlspecialchars($row['record_date']) ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </article>
        </section>
    </div>
</main>

<footer class="site-footer">
    <p class="mb-0">AfyaSmart professional web experience.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>








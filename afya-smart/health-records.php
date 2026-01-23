
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
    <title>Health Records | AfyaSmart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">AfyaSmart</a>
    </div>
</nav>

<section class="container my-5">
    <h2 class="text-center text-success mb-4">Health Records</h2>

    <div class="row">
        <!-- Add Record -->
        <div class="col-md-5">
            <div class="card p-4 shadow">
                <h5>Add Health Record</h5>

                <form method="POST" action="backend/save_health_record.php">
                    <div class="mb-3">
                        <label>Record Type</label>
                        <select name="recordType" class="form-select" required>
                            <option value="">-- Select --</option>
                            <option value="Allergy">Allergy</option>
                            <option value="Medication">Medication</option>
                            <option value="Condition">Medical Condition</option>
                            <option value="Vaccination">Vaccination</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Date</label>
                        <input type="date" name="recordDate" class="form-control" required>
                    </div>

                    <button class="btn btn-success w-100">Save Record</button>
                </form>
            </div>
        </div>

        <!-- View Records -->
        <div class="col-md-7">
            <div class="card p-4 shadow">
                <h5>My Records</h5>

                <table class="table table-bordered">
                    <thead class="table-success">
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
    </div>
</section>

</body>
</html>

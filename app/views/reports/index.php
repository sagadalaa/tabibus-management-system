<?php
/**
 * Reports Template for Clinic Management System
 * Author: Your Name
 * Description: Displays statistical charts and reports for clinic data.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example report data (replace with dynamic backend data)
$reportData = $reportData ?? [
    'new_patients' => 50,
    'temporary_appointments' => 20,
    'approved_appointments' => 30,
    'completed_appointments' => 40,
    'total_income' => 5000,
];

// Error or success messages
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Reports - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Reports | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="reports-container">
        <div class="reports-header">
            <h1><?= t('Reports') ?></h1>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="charts-container">
            <div class="chart-section">
                <canvas id="patientsChart"></canvas>
            </div>
            <div class="chart-section">
                <canvas id="appointmentsChart"></canvas>
            </div>
            <div class="chart-section">
                <canvas id="incomeChart"></canvas>
            </div>
        </div>

        <div class="report-controls">
            <form action="/reports/generate" method="GET" class="generate-report-form">
                <label for="report_type"><?= t('Select Report Type') ?></label>
                <select name="report_type" id="report_type" required>
                    <option value=""><?= t('Choose...') ?></option>
                    <option value="new_patients"><?= t('New Patients') ?></option>
                    <option value="temporary_appointments"><?= t('Temporary Appointments') ?></option>
                    <option value="approved_appointments"><?= t('Approved Appointments') ?></option>
                    <option value="completed_appointments"><?= t('Completed Appointments') ?></option>
                    <option value="income"><?= t('Total Income') ?></option>
                </select>

                <label for="date_range"><?= t('Select Date Range') ?></label>
                <input type="date" name="start_date" required>
                <input type="date" name="end_date" required>

                <button type="submit" class="btn btn-primary"><?= t('Generate Report') ?></button>
            </form>
        </div>
    </main>

    <script>
        // Patients Chart
        const patientsCtx = document.getElementById('patientsChart').getContext('2d');
        new Chart(patientsCtx, {
            type: 'bar',
            data: {
                labels: ['New Patients'],
                datasets: [{
                    label: 'New Patients',
                    data: [<?= $reportData['new_patients'] ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Appointments Chart
        const appointmentsCtx = document.getElementById('appointmentsChart').getContext('2d');
        new Chart(appointmentsCtx, {
            type: 'pie',
            data: {
                labels: ['Temporary', 'Approved', 'Completed'],
                datasets: [{
                    label: 'Appointments',
                    data: [<?= $reportData['temporary_appointments'] ?>, <?= $reportData['approved_appointments'] ?>, <?= $reportData['completed_appointments'] ?>],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                    borderWidth: 1
                }]
            },
        });

        // Income Chart
        const incomeCtx = document.getElementById('incomeChart').getContext('2d');
        new Chart(incomeCtx, {
            type: 'line',
            data: {
                labels: ['Income'],
                datasets: [{
                    label: 'Total Income',
                    data: [<?= $reportData['total_income'] ?>],
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>

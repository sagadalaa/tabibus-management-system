<?php
/**
 * Dashboard Template for Clinic Management System
 * Author: Your Name
 * Description: Displays the main dashboard with key metrics and quick actions.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$userName = $_SESSION['user_name'] ?? 'Guest';
$clinicName = $_SESSION['clinic_name'] ?? 'Your Clinic';

// Example data - Replace with dynamic data from the backend
$metrics = [
    'new_patients' => 25,
    'appointments_today' => 40,
    'completed_appointments' => 32,
    'income_today' => 1500.00,
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <script src="/assets/js/charts.js"></script>
    <title>Dashboard | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="dashboard-container">
        <div class="dashboard-header">
            <h1><?= t('Welcome Back') ?>, <?= htmlspecialchars($userName) ?></h1>
            <p><?= t('Here is your clinic overview for today') ?>.</p>
        </div>

        <!-- Metrics Section -->
        <div class="dashboard-metrics">
            <div class="metric-card">
                <h3><?= t('New Patients') ?></h3>
                <p><?= $metrics['new_patients'] ?></p>
            </div>
            <div class="metric-card">
                <h3><?= t('Appointments Today') ?></h3>
                <p><?= $metrics['appointments_today'] ?></p>
            </div>
            <div class="metric-card">
                <h3><?= t('Completed Appointments') ?></h3>
                <p><?= $metrics['completed_appointments'] ?></p>
            </div>
            <div class="metric-card">
                <h3><?= t('Income Today') ?></h3>
                <p>$<?= number_format($metrics['income_today'], 2) ?></p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="dashboard-charts">
            <div class="chart-card">
                <h3><?= t('Appointments Overview') ?></h3>
                <canvas id="appointmentsChart"></canvas>
            </div>
            <div class="chart-card">
                <h3><?= t('Income Overview') ?></h3>
                <canvas id="incomeChart"></canvas>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="dashboard-actions">
            <h3><?= t('Quick Actions') ?></h3>
            <div class="actions-grid">
                <a href="/patients/add" class="action-card">
                    <i class="icon icon-patient"></i>
                    <span><?= t('Add Patient') ?></span>
                </a>
                <a href="/appointments/add" class="action-card">
                    <i class="icon icon-appointment"></i>
                    <span><?= t('Add Appointment') ?></span>
                </a>
                <a href="/reports" class="action-card">
                    <i class="icon icon-reports"></i>
                    <span><?= t('View Reports') ?></span>
                </a>
                <a href="/system" class="action-card">
                    <i class="icon icon-settings"></i>
                    <span><?= t('Manage System') ?></span>
                </a>
            </div>
        </div>
    </main>

    <script>
        // Example Chart.js Implementation
        const appointmentsData = {
            labels: ['New', 'Approved', 'Completed'],
            datasets: [{
                label: 'Appointments',
                data: [15, 20, 32],
                backgroundColor: ['#007bff', '#28a745', '#dc3545'],
            }]
        };

        const incomeData = {
            labels: ['January', 'February', 'March', 'April'],
            datasets: [{
                label: 'Income',
                data: [5000, 7000, 6000, 8000],
                backgroundColor: '#007bff',
            }]
        };

        const appointmentsChart = new Chart(
            document.getElementById('appointmentsChart'),
            {
                type: 'doughnut',
                data: appointmentsData,
            }
        );

        const incomeChart = new Chart(
            document.getElementById('incomeChart'),
            {
                type: 'bar',
                data: incomeData,
            }
        );
    </script>
    <?php include __DIR__ . '/../templates/footer.php'; ?>
</body>
</html>

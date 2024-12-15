<?php
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/config/language.php';
require __DIR__ . '/../app/helpers/functions.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

// Determine text direction
$dir = ($lang === 'ar') ? 'rtl' : 'ltr';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - <?= t('dashboard') ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <?php if ($dir === 'rtl'): ?>
    <link rel="stylesheet" href="assets/css/theme-ar.css">
    <?php endif; ?>
    <link rel="icon" href="assets/images/logo.png" type="image/png">

    <!-- Chart.js (for the chart demonstration) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
            <img src="assets/images/logo.png" alt="Clinic Logo" width="40" height="40" class="me-2">
            <span><?= SITE_NAME ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="<?= t('toggle_navigation') ?>">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="patient.php"><?= t('patients') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="appointments.php"><?= t('appointments') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="services.php"><?= t('services') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="reports.php"><?= t('reports') ?></a></li>
                <?php if ($_SESSION['user_role'] !== 'receptionist'): ?>
                <li class="nav-item"><a class="nav-link" href="system.php"><?= t('system') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="messages.php"><?= t('messages') ?></a></li>
                <?php endif; ?>
            </ul>
            <div class="d-flex">
                <a href="?lang=en" class="btn btn-sm btn-outline-primary me-1">EN</a>
                <a href="?lang=ar" class="btn btn-sm btn-outline-primary me-3">AR</a>
                <a href="logout.php" class="btn btn-sm btn-outline-danger"><?= t('logout') ?></a>
            </div>
        </div>
    </div>
</nav>

<div class="container my-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div>
            <h2 class="mb-1"><?= t('dashboard') ?></h2>
            <p class="text-muted mb-0"><?= t('welcome_user', ['user' => $_SESSION['user_name'] ?? '']) ?> - <?= t('clinic') ?>: <?= t('your_clinic_name') ?></p>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-2">
            <a href="patient.php?action=add" class="btn btn-primary"><?= t('add_patient') ?></a>
            <a href="appointments.php?action=add" class="btn btn-success"><?= t('add_appointment') ?></a>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= t('new_patients') ?></h5>
                    <p class="card-text display-6 fw-bold">25</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= t('new_appointments') ?></h5>
                    <p class="card-text display-6 fw-bold">40</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= t('temporary_appointments') ?></h5>
                    <p class="card-text display-6 fw-bold">10</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= t('total_income') ?></h5>
                    <p class="card-text display-6 fw-bold">1200 IQD</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeframe Switch for Chart & Calendar -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4><?= t('appointments_over_time') ?></h4>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary"><?= t('daily') ?></button>
            <button type="button" class="btn btn-outline-primary"><?= t('weekly') ?></button>
            <button type="button" class="btn btn-outline-primary"><?= t('monthly') ?></button>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <canvas id="appointmentsChart" height="100"></canvas>
        </div>
    </div>

    <!-- Calendar Section -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4><?= t('calendar_view') ?></h4>
        <button class="btn btn-primary"><?= t('add_appointment') ?></button>
    </div>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <!-- Placeholder calendar: You can replace this with a real calendar library -->
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><?= t('sunday') ?></th>
                            <th><?= t('monday') ?></th>
                            <th><?= t('tuesday') ?></th>
                            <th><?= t('wednesday') ?></th>
                            <th><?= t('thursday') ?></th>
                            <th><?= t('friday') ?></th>
                            <th><?= t('saturday') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="text-muted">1</span></td>
                            <td><span class="text-muted">2</span></td>
                            <td><span class="text-muted">3</span></td>
                            <td><span class="text-muted">4</span></td>
                            <td><span class="text-muted">5</span></td>
                            <td><span class="text-muted">6</span></td>
                            <td><span class="text-muted">7</span></td>
                        </tr>
                        <!-- Add more rows and mark appointments as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<footer class="mt-auto bg-white py-4 border-top">
    <div class="container text-center">
        <p class="mb-0 text-muted">&copy; <?= date('Y') ?> <?= SITE_NAME ?>. <?= t('all_rights_reserved') ?></p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/main.js"></script>
<script src="assets/js/charts.js"></script>
<script>
// Example Chart Initialization
const ctx = document.getElementById('appointmentsChart');
const appointmentsChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        datasets: [{
            label: 'Appointments',
            data: [30, 45, 25, 50],
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: false,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
</body>
</html>

<?php
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/config/language.php';
require __DIR__ . '/../app/helpers/functions.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

$dir = ($lang === 'ar') ? 'rtl' : 'ltr';

// Example placeholders for report data
// In a real scenario, fetch from the database based on selected criteria and date range
$reportType = $_GET['report_type'] ?? 'new_patients'; 
$startDate = $_GET['start_date'] ?? date('Y-m-01');
$endDate = $_GET['end_date'] ?? date('Y-m-d');
$timeFrame = $_GET['timeframe'] ?? 'daily'; // daily, weekly, monthly

// Placeholder data for the chart
$labels = ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5'];
$dataValues = [10, 20, 15, 25, 30]; // Example values

?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - <?= t('reports') ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <?php if ($dir === 'rtl'): ?>
    <link rel="stylesheet" href="assets/css/theme-ar.css">
    <?php endif; ?>
    <link rel="icon" href="assets/images/logo.png" type="image/png">
    <!-- Chart.js -->
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
                <li class="nav-item"><a class="nav-link active" href="reports.php"><?= t('reports') ?></a></li>
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
    <h2 class="mb-4"><?= t('reports') ?></h2>

    <form class="row g-3 mb-4" action="" method="get">
        <div class="col-md-4">
            <label for="report_type" class="form-label"><?= t('report_type') ?></label>
            <select name="report_type" id="report_type" class="form-select">
                <option value="new_patients" <?= ($reportType === 'new_patients') ? 'selected' : '' ?>><?= t('new_patients') ?></option>
                <option value="temporary_appointments" <?= ($reportType === 'temporary_appointments') ? 'selected' : '' ?>><?= t('temporary_appointments') ?></option>
                <option value="approved_appointments" <?= ($reportType === 'approved_appointments') ? 'selected' : '' ?>><?= t('approved_appointments') ?></option>
                <option value="completed_appointments" <?= ($reportType === 'completed_appointments') ? 'selected' : '' ?>><?= t('completed_appointments') ?></option>
                <option value="total_income" <?= ($reportType === 'total_income') ? 'selected' : '' ?>><?= t('total_income') ?></option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="start_date" class="form-label"><?= t('start_date') ?></label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="<?= htmlspecialchars($startDate) ?>">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label"><?= t('end_date') ?></label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="<?= htmlspecialchars($endDate) ?>">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100"><?= t('generate_report') ?></button>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><?= t('report_results') ?>: <?= t($reportType) ?></h4>
        <div class="btn-group" role="group" aria-label="<?= t('timeframe') ?>">
            <a href="?report_type=<?= $reportType ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>&timeframe=daily" class="btn btn-outline-primary <?= ($timeFrame === 'daily') ? 'active' : '' ?>"><?= t('daily') ?></a>
            <a href="?report_type=<?= $reportType ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>&timeframe=weekly" class="btn btn-outline-primary <?= ($timeFrame === 'weekly') ? 'active' : '' ?>"><?= t('weekly') ?></a>
            <a href="?report_type=<?= $reportType ?>&start_date=<?= $startDate ?>&end_date=<?= $endDate ?>&timeframe=monthly" class="btn btn-outline-primary <?= ($timeFrame === 'monthly') ? 'active' : '' ?>"><?= t('monthly') ?></a>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <canvas id="reportChart" height="100"></canvas>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#detailedReportModal"><?= t('view_detailed_report') ?></button>
    </div>

    <!-- Detailed Report Modal -->
    <div class="modal fade" id="detailedReportModal" tabindex="-1" aria-labelledby="detailedReportLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= t('detailed_report') ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= t('close') ?>"></button>
                </div>
                <div class="modal-body">
                    <!-- Detailed data goes here. In a real scenario, this might be a table of results -->
                    <h6><?= t('report_type') ?>: <?= t($reportType) ?></h6>
                    <p><?= t('date_range') ?>: <?= htmlspecialchars($startDate) ?> - <?= htmlspecialchars($endDate) ?></p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?= t('date') ?></th>
                                <th><?= t('value') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Placeholder rows. Populate with actual data -->
                            <?php foreach ($labels as $index => $label): ?>
                            <tr>
                                <td><?= htmlspecialchars($label) ?></td>
                                <td><?= htmlspecialchars($dataValues[$index]) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <hr>
                    <p><?= t('print_instructions') ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= t('close') ?></button>
                    <button type="button" class="btn btn-primary" onclick="printReport()"><?= t('print_report') ?></button>
                </div>
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
<script>
// Initialize Chart
const ctx = document.getElementById('reportChart');
const reportChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: '<?= t($reportType) ?>',
            data: <?= json_encode($dataValues) ?>,
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

function printReport() {
    // Open a new window and print the detailed modal content
    const modalContent = document.querySelector('#detailedReportModal .modal-body').innerHTML;
    const newWin = window.open('', '', 'width=800,height=600');
    newWin.document.write(`<html><head><title><?= t('print_report') ?></title></head><body>${modalContent}</body></html>`);
    newWin.document.close();
    newWin.focus();
    newWin.print();
    newWin.close();
}
</script>
</body>
</html>

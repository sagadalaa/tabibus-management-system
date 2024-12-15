<?php
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/config/language.php';
require __DIR__ . '/../app/helpers/functions.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

$dir = ($lang === 'ar') ? 'rtl' : 'ltr';

// Placeholder data, in a real scenario fetch from AppointmentModel
$temporaryAppointments = [
    ['id' => 1, 'patient_name' => 'John Doe', 'date' => '2024-12-20 10:00', 'type' => 'temporary'],
    ['id' => 2, 'patient_name' => 'Jane Smith', 'date' => '2024-12-20 11:00', 'type' => 'temporary']
];

$approvedAppointments = [
    ['id' => 3, 'patient_name' => 'Ali Hassan', 'date' => '2024-12-20 12:00', 'type' => 'approved', 'initial_checks' => 'Temp: 37C, BP:120/80']
];

$activeAppointments = [
    ['id' => 4, 'patient_name' => 'Maryam Karim', 'date' => '2024-12-20 13:00', 'type' => 'active', 'doctor_notes' => '', 'files' => []]
];

$finishedAppointments = [
    ['id' => 5, 'patient_name' => 'Omar Al-Sadi', 'date' => '2024-12-19 09:00', 'type' => 'finished', 'result_report' => 'Diagnosis and prescription details...']
];

// Example daily limits (these would come from the system settings)
$dailyTempLimit = 10;
$dailyApprovedLimit = 20;
$dailyCompletedLimit = 20;
$currentTempCount = count($temporaryAppointments);
$currentApprovedCount = count($approvedAppointments);
$currentActiveCount = count($activeAppointments);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - <?= t('appointments') ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <?php if ($dir === 'rtl'): ?>
    <link rel="stylesheet" href="assets/css/theme-ar.css">
    <?php endif; ?>
    <link rel="icon" href="assets/images/logo.png" type="image/png">
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
                <li class="nav-item"><a class="nav-link active" href="appointments.php"><?= t('appointments') ?></a></li>
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

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <h2 class="mb-3 mb-md-0"><?= t('appointments') ?></h2>
        <div class="d-flex gap-2">
            <!-- Search Bar for Patient or Appointment -->
            <form class="d-flex" method="get" action="">
                <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="<?= t('search_patient_or_appointment') ?>" aria-label="Search" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                <button class="btn btn-sm btn-primary" type="submit"><?= t('search') ?></button>
            </form>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addAppointmentModal"><?= t('add_appointment') ?></button>
        </div>
    </div>

    <!-- Display Daily Limits -->
    <div class="mb-3">
        <span class="badge bg-info"><?= t('temporary_appointments_limit') ?>: <?= $currentTempCount ?>/<?= $dailyTempLimit ?></span>
        <span class="badge bg-info"><?= t('approved_appointments_limit') ?>: <?= $currentApprovedCount ?>/<?= $dailyApprovedLimit ?></span>
        <span class="badge bg-info"><?= t('active_appointments_limit') ?>: <?= $currentActiveCount ?>/<?= $dailyCompletedLimit ?></span>
    </div>

    <!-- Tabs for Different Appointment Types -->
    <ul class="nav nav-tabs mb-4" id="appointmentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="temp-tab" data-bs-toggle="tab" data-bs-target="#temp-pane" type="button" role="tab" aria-controls="temp-pane" aria-selected="true"><?= t('temporary_appointments') ?> (<?= count($temporaryAppointments) ?>)</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved-pane" type="button" role="tab" aria-controls="approved-pane" aria-selected="false"><?= t('approved_appointments') ?> (<?= count($approvedAppointments) ?>)</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="active-tab" data-bs-toggle="tab" data-bs-target="#active-pane" type="button" role="tab" aria-controls="active-pane" aria-selected="false"><?= t('active_appointments') ?> (<?= count($activeAppointments) ?>)</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="finished-tab" data-bs-toggle="tab" data-bs-target="#finished-pane" type="button" role="tab" aria-controls="finished-pane" aria-selected="false"><?= t('finished_appointments') ?> (<?= count($finishedAppointments) ?>)</button>
        </li>
    </ul>

    <div class="tab-content" id="appointmentTabsContent">
        <!-- Temporary Appointments Pane -->
        <div class="tab-pane fade show active" id="temp-pane" role="tabpanel" aria-labelledby="temp-tab">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><?= t('patient_name') ?></th>
                                    <th><?= t('appointment_date') ?></th>
                                    <th><?= t('actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($temporaryAppointments) > 0): ?>
                                    <?php foreach ($temporaryAppointments as $app): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($app['patient_name']) ?></td>
                                        <td><?= htmlspecialchars($app['date']) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="convertToApproved(<?= $app['id'] ?>)"><?= t('convert_to_approved') ?></button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteAppointment(<?= $app['id'] ?>)"><?= t('delete') ?></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center text-muted"><?= t('no_temporary_appointments') ?></td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approved Appointments Pane -->
        <div class="tab-pane fade" id="approved-pane" role="tabpanel" aria-labelledby="approved-tab">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><?= t('patient_name') ?></th>
                                    <th><?= t('appointment_date') ?></th>
                                    <th><?= t('initial_checks') ?></th>
                                    <th><?= t('actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($approvedAppointments) > 0): ?>
                                    <?php foreach ($approvedAppointments as $app): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($app['patient_name']) ?></td>
                                        <td><?= htmlspecialchars($app['date']) ?></td>
                                        <td><?= htmlspecialchars($app['initial_checks'] ?? '') ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-success" onclick="moveToActive(<?= $app['id'] ?>)"><?= t('start_appointment') ?></button>
                                            <button class="btn btn-sm btn-warning" onclick="editAppointment(<?= $app['id'] ?>)"><?= t('edit') ?></button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteAppointment(<?= $app['id'] ?>)"><?= t('delete') ?></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center text-muted"><?= t('no_approved_appointments') ?></td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Appointments Pane -->
        <div class="tab-pane fade" id="active-pane" role="tabpanel" aria-labelledby="active-tab">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><?= t('patient_name') ?></th>
                                    <th><?= t('appointment_date') ?></th>
                                    <th><?= t('doctor_notes') ?></th>
                                    <th><?= t('actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($activeAppointments) > 0): ?>
                                    <?php foreach ($activeAppointments as $app): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($app['patient_name']) ?></td>
                                        <td><?= htmlspecialchars($app['date']) ?></td>
                                        <td><?= htmlspecialchars($app['doctor_notes'] ?? '') ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="uploadFiles(<?= $app['id'] ?>)"><?= t('upload_files') ?></button>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?= t('mark_as') ?></button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="markAsRecheck(<?= $app['id'] ?>)"><?= t('recheck') ?></a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="finishAppointment(<?= $app['id'] ?>)"><?= t('finish') ?></a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center text-muted"><?= t('no_active_appointments') ?></td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Finished Appointments Pane -->
        <div class="tab-pane fade" id="finished-pane" role="tabpanel" aria-labelledby="finished-tab">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><?= t('patient_name') ?></th>
                                    <th><?= t('appointment_date') ?></th>
                                    <th><?= t('result_report') ?></th>
                                    <th><?= t('actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($finishedAppointments) > 0): ?>
                                    <?php foreach ($finishedAppointments as $app): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($app['patient_name']) ?></td>
                                        <td><?= htmlspecialchars($app['date']) ?></td>
                                        <td><?= htmlspecialchars($app['result_report'] ?? '') ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="printReport(<?= $app['id'] ?>)"><?= t('print_result') ?></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center text-muted"><?= t('no_finished_appointments') ?></td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
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

<!-- Add Appointment Modal -->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= t('add_appointment') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= t('close') ?>"></button>
            </div>
            <div class="modal-body">
                <form action="appointments.php?action=add" method="post">
                    <div class="mb-3">
                        <label for="patient_id" class="form-label"><?= t('patient') ?></label>
                        <select name="patient_id" id="patient_id" class="form-select" required>
                            <!-- Populate patients from database -->
                            <option value="1">John Doe</option>
                            <option value="2">Jane Smith</option>
                            <!-- ... -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label"><?= t('appointment_date') ?></label>
                        <input type="datetime-local" name="date" id="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="service_id" class="form-label"><?= t('service') ?></label>
                        <select name="service_id" id="service_id" class="form-select" required>
                            <!-- Populate services from database -->
                            <option value="1"><?= t('regular_visit') ?> - 50 IQD</option>
                            <option value="2"><?= t('recheck') ?> - 20 IQD</option>
                            <!-- ... -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success"><?= t('add_appointment') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Action Scripts: These would call backend actions via AJAX or simple post -->
<script>
function convertToApproved(id) {
    if (confirm('<?= t('confirm_convert_approved') ?>')) {
        // Perform AJAX or redirect to action
        window.location = 'appointments.php?action=convert_approved&id=' + id;
    }
}
function deleteAppointment(id) {
    if (confirm('<?= t('confirm_delete_appointment') ?>')) {
        window.location = 'appointments.php?action=delete&id=' + id;
    }
}
function moveToActive(id) {
    window.location = 'appointments.php?action=move_active&id=' + id;
}
function editAppointment(id) {
    window.location = 'appointments.php?action=edit&id=' + id;
}
function uploadFiles(id) {
    window.location = 'appointments.php?action=upload_files&id=' + id;
}
function markAsRecheck(id) {
    window.location = 'appointments.php?action=mark_recheck&id=' + id;
}
function finishAppointment(id) {
    window.location = 'appointments.php?action=finish&id=' + id;
}
function printReport(id) {
    window.open('reports.php?action=print&id=' + id, '_blank');
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/main.js"></script>
</body>
</html>

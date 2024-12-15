<?php
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/config/language.php';
require __DIR__ . '/../app/helpers/functions.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

// Check user role if needed (e.g., only clinic_admin or administrator can access)
if ($_SESSION['user_role'] !== 'clinic_admin' && $_SESSION['user_role'] !== 'administrator') {
    redirect('dashboard.php');
}

$dir = ($lang === 'ar') ? 'rtl' : 'ltr';

// Placeholder data for clinic info, receptionists, subscription, and support
$clinicInfo = [
    'name' => 'My Clinic',
    'doctor_name' => 'Dr. John Doe',
    'address' => '1234 Health St, Baghdad, Iraq',
    'phone' => '1234567890',
    'social_links' => 'Facebook: fb.com/myclinic',
    'currency' => 'IQD',
    'temp_limit' => 10,
    'approved_limit' => 20,
    'completed_limit' => 20,
];

$receptionists = [
    ['id' => 1, 'full_name' => 'Ali Saad', 'username' => 'ali123', 'status' => 'active'],
    ['id' => 2, 'full_name' => 'Fatima Ahmed', 'username' => 'fatima', 'status' => 'disabled']
];

$subscription = [
    'type' => '6_months',
    'price' => '200',
    'expiry_date' => '2025-06-30',
    'status' => 'paid'
];

$supportInfo = [
    'links' => 'https://support.example.com',
    'phone' => '+964123456789'
];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - <?= t('system') ?></title>
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
                <li class="nav-item"><a class="nav-link" href="appointments.php"><?= t('appointments') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="services.php"><?= t('services') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="reports.php"><?= t('reports') ?></a></li>
                <?php if ($_SESSION['user_role'] !== 'receptionist'): ?>
                <li class="nav-item"><a class="nav-link active" href="system.php"><?= t('system') ?></a></li>
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
    <h2 class="mb-4"><?= t('system_settings') ?></h2>

    <!-- Clinic Information -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><?= t('clinic_information') ?></h5>
        </div>
        <div class="card-body">
            <form action="system.php?action=update_clinic_info" method="post">
                <div class="mb-3">
                    <label for="clinic_name" class="form-label"><?= t('clinic_name') ?></label>
                    <input type="text" name="name" id="clinic_name" class="form-control" value="<?= htmlspecialchars($clinicInfo['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="doctor_name" class="form-label"><?= t('doctor_name') ?></label>
                    <input type="text" name="doctor_name" id="doctor_name" class="form-control" value="<?= htmlspecialchars($clinicInfo['doctor_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label"><?= t('address') ?></label>
                    <textarea name="address" id="address" class="form-control" rows="2" required><?= htmlspecialchars($clinicInfo['address']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label"><?= t('phone_number') ?></label>
                    <input type="text" name="phone" id="phone" class="form-control" value="<?= htmlspecialchars($clinicInfo['phone']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="social_links" class="form-label"><?= t('social_links') ?></label>
                    <input type="text" name="social_links" id="social_links" class="form-control" value="<?= htmlspecialchars($clinicInfo['social_links']) ?>">
                </div>
                <button type="submit" class="btn btn-success"><?= t('save_changes') ?></button>
            </form>
        </div>
    </div>

    <!-- Receptionist Management -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?= t('receptionist_users') ?></h5>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addReceptionistModal"><?= t('add_receptionist') ?></button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><?= t('full_name') ?></th>
                            <th><?= t('username') ?></th>
                            <th><?= t('status') ?></th>
                            <th><?= t('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($receptionists) > 0): ?>
                            <?php foreach ($receptionists as $rec): ?>
                            <tr>
                                <td><?= htmlspecialchars($rec['full_name']) ?></td>
                                <td><?= htmlspecialchars($rec['username']) ?></td>
                                <td>
                                    <?php if ($rec['status'] === 'active'): ?>
                                        <span class="badge bg-success"><?= t('active') ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= t('disabled') ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editReceptionist(<?= $rec['id'] ?>)"><?= t('edit') ?></button>
                                    <?php if ($rec['status'] === 'active'): ?>
                                        <button class="btn btn-sm btn-secondary" onclick="disableReceptionist(<?= $rec['id'] ?>)"><?= t('disable') ?></button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-primary" onclick="enableReceptionist(<?= $rec['id'] ?>)"><?= t('enable') ?></button>
                                    <?php endif; ?>
                                    <button class="btn btn-sm btn-danger" onclick="deleteReceptionist(<?= $rec['id'] ?>)"><?= t('delete') ?></button>
                                    <button class="btn btn-sm btn-info" onclick="showPassword(<?= $rec['id'] ?>)"><?= t('show_password') ?></button>
                                    <button class="btn btn-sm btn-dark" onclick="changePassword(<?= $rec['id'] ?>)"><?= t('change_password') ?></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-muted"><?= t('no_receptionists_found') ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Currency and Appointment Limits -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><?= t('system_settings') ?></h5>
        </div>
        <div class="card-body">
            <form action="system.php?action=update_settings" method="post">
                <div class="mb-3">
                    <label for="currency" class="form-label"><?= t('currency_used') ?></label>
                    <input type="text" name="currency" id="currency" class="form-control" value="<?= htmlspecialchars($clinicInfo['currency']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?= t('appointment_limits') ?></label>
                    <div class="d-flex gap-2">
                        <div>
                            <label for="temp_limit" class="form-label small"><?= t('temporary_appointments_limit') ?></label>
                            <input type="number" name="temp_limit" id="temp_limit" class="form-control" value="<?= (int)$clinicInfo['temp_limit'] ?>">
                        </div>
                        <div>
                            <label for="approved_limit" class="form-label small"><?= t('approved_appointments_limit') ?></label>
                            <input type="number" name="approved_limit" id="approved_limit" class="form-control" value="<?= (int)$clinicInfo['approved_limit'] ?>">
                        </div>
                        <div>
                            <label for="completed_limit" class="form-label small"><?= t('completed_appointments_limit') ?></label>
                            <input type="number" name="completed_limit" id="completed_limit" class="form-control" value="<?= (int)$clinicInfo['completed_limit'] ?>">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success"><?= t('save_changes') ?></button>
            </form>
        </div>
    </div>

    <!-- Subscription Details -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><?= t('subscription_details') ?></h5>
        </div>
        <div class="card-body">
            <p><?= t('current_subscription') ?>: <?= t($subscription['type']) ?> (<?= htmlspecialchars($subscription['price']) ?> IQD)</p>
            <p><?= t('expiry_date') ?>: <?= htmlspecialchars($subscription['expiry_date']) ?></p>
            <p><?= t('status') ?>: 
                <?php if ($subscription['status'] === 'paid'): ?>
                    <span class="badge bg-success"><?= t('paid') ?></span>
                <?php else: ?>
                    <span class="badge bg-warning"><?= t('unpaid') ?></span>
                <?php endif; ?>
            </p>
            <!-- Add functionality for renewing or changing subscription as needed -->
        </div>
    </div>

    <!-- Support Information -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><?= t('support_information') ?></h5>
        </div>
        <div class="card-body">
            <p><?= t('support_links') ?>: <a href="<?= htmlspecialchars($supportInfo['links']) ?>" target="_blank"><?= htmlspecialchars($supportInfo['links']) ?></a></p>
            <p><?= t('support_phone') ?>: <?= htmlspecialchars($supportInfo['phone']) ?></p>
        </div>
    </div>
</div>

<footer class="mt-auto bg-white py-4 border-top">
    <div class="container text-center">
        <p class="mb-0 text-muted">&copy; <?= date('Y') ?> <?= SITE_NAME ?>. <?= t('all_rights_reserved') ?></p>
    </div>
</footer>

<!-- Add Receptionist Modal -->
<div class="modal fade" id="addReceptionistModal" tabindex="-1" aria-labelledby="addReceptionistLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= t('add_receptionist') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= t('close') ?>"></button>
            </div>
            <div class="modal-body">
                <form action="system.php?action=add_receptionist" method="post">
                    <div class="mb-3">
                        <label for="rec_full_name" class="form-label"><?= t('full_name') ?></label>
                        <input type="text" name="full_name" id="rec_full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rec_username" class="form-label"><?= t('username') ?></label>
                        <input type="text" name="username" id="rec_username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rec_password" class="form-label"><?= t('password') ?></label>
                        <input type="password" name="password" id="rec_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success"><?= t('add_receptionist') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Action Scripts -->
<script>
function editReceptionist(id) {
    window.location = 'system.php?action=edit_receptionist&id=' + id;
}
function disableReceptionist(id) {
    if (confirm('<?= t('confirm_disable_receptionist') ?>')) {
        window.location = 'system.php?action=disable_receptionist&id=' + id;
    }
}
function enableReceptionist(id) {
    if (confirm('<?= t('confirm_enable_receptionist') ?>')) {
        window.location = 'system.php?action=enable_receptionist&id=' + id;
    }
}
function deleteReceptionist(id) {
    if (confirm('<?= t('confirm_delete_receptionist') ?>')) {
        window.location = 'system.php?action=delete_receptionist&id=' + id;
    }
}
function showPassword(id) {
    window.location = 'system.php?action=show_password&id=' + id;
}
function changePassword(id) {
    window.location = 'system.php?action=change_password&id=' + id;
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/main.js"></script>
</body>
</html>

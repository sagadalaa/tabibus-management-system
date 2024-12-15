<?php
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/config/language.php';
require __DIR__ . '/../app/helpers/functions.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

$dir = ($lang === 'ar') ? 'rtl' : 'ltr';

// Placeholder arrays for services and medicines. In a real scenario, fetch from the database.
$services = [
    ['id' => 1, 'service_name' => 'Regular Checkup', 'price' => '50'],
    ['id' => 2, 'service_name' => 'Recheck', 'price' => '20']
];

$medicines = [
    ['id' => 1, 'medicine_name' => 'Paracetamol', 'dosage' => '500mg', 'usage_instructions' => 'Twice daily after meals'],
    ['id' => 2, 'medicine_name' => 'Amoxicillin', 'dosage' => '250mg', 'usage_instructions' => 'Three times daily before meals']
];

?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - <?= t('services') ?></title>
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
                <li class="nav-item"><a class="nav-link active" href="services.php"><?= t('services') ?></a></li>
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
        <h2 class="mb-3 mb-md-0"><?= t('services_and_medicines') ?></h2>
        <form class="d-flex" method="get" action="">
            <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="<?= t('search_services_or_medicines') ?>" aria-label="Search" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            <button class="btn btn-sm btn-primary" type="submit"><?= t('search') ?></button>
        </form>
    </div>

    <ul class="nav nav-tabs mb-4" id="servicesTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="services-tab" data-bs-toggle="tab" data-bs-target="#services-pane" type="button" role="tab" aria-controls="services-pane" aria-selected="true"><?= t('services') ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="medicines-tab" data-bs-toggle="tab" data-bs-target="#medicines-pane" type="button" role="tab" aria-controls="medicines-pane" aria-selected="false"><?= t('medicines') ?></button>
        </li>
    </ul>

    <div class="tab-content" id="servicesTabsContent">
        <!-- Services Pane -->
        <div class="tab-pane fade show active" id="services-pane" role="tabpanel" aria-labelledby="services-tab">
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addServiceModal"><?= t('add_service') ?></button>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><?= t('service_name') ?></th>
                                    <th><?= t('price') ?></th>
                                    <th><?= t('actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($services) > 0): ?>
                                    <?php foreach ($services as $service): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($service['service_name']) ?></td>
                                        <td><?= htmlspecialchars($service['price']) ?> IQD</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" onclick="editService(<?= $service['id'] ?>)"><?= t('edit') ?></button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteService(<?= $service['id'] ?>)"><?= t('delete') ?></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center text-muted"><?= t('no_services_found') ?></td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medicines Pane -->
        <div class="tab-pane fade" id="medicines-pane" role="tabpanel" aria-labelledby="medicines-tab">
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addMedicineModal"><?= t('add_medicine') ?></button>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><?= t('medicine_name') ?></th>
                                    <th><?= t('dosage') ?></th>
                                    <th><?= t('usage_instructions') ?></th>
                                    <th><?= t('actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($medicines) > 0): ?>
                                    <?php foreach ($medicines as $med): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($med['medicine_name']) ?></td>
                                        <td><?= htmlspecialchars($med['dosage']) ?></td>
                                        <td><?= htmlspecialchars($med['usage_instructions']) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" onclick="editMedicine(<?= $med['id'] ?>)"><?= t('edit') ?></button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteMedicine(<?= $med['id'] ?>)"><?= t('delete') ?></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center text-muted"><?= t('no_medicines_found') ?></td></tr>
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

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= t('add_service') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= t('close') ?>"></button>
            </div>
            <div class="modal-body">
                <form action="services.php?action=add_service" method="post">
                    <div class="mb-3">
                        <label for="service_name" class="form-label"><?= t('service_name') ?></label>
                        <input type="text" name="service_name" id="service_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="service_price" class="form-label"><?= t('price') ?></label>
                        <input type="number" name="price" id="service_price" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success"><?= t('add_service') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Medicine Modal -->
<div class="modal fade" id="addMedicineModal" tabindex="-1" aria-labelledby="addMedicineLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= t('add_medicine') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= t('close') ?>"></button>
            </div>
            <div class="modal-body">
                <form action="services.php?action=add_medicine" method="post">
                    <div class="mb-3">
                        <label for="medicine_name" class="form-label"><?= t('medicine_name') ?></label>
                        <input type="text" name="medicine_name" id="medicine_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="dosage" class="form-label"><?= t('dosage') ?></label>
                        <input type="text" name="dosage" id="dosage" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="usage_instructions" class="form-label"><?= t('usage_instructions') ?></label>
                        <textarea name="usage_instructions" id="usage_instructions" class="form-control" rows="2" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success"><?= t('add_medicine') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Action Scripts (to be implemented) -->
<script>
function editService(id) {
    window.location = 'services.php?action=edit_service&id=' + id;
}
function deleteService(id) {
    if (confirm('<?= t('confirm_delete_service') ?>')) {
        window.location = 'services.php?action=delete_service&id=' + id;
    }
}
function editMedicine(id) {
    window.location = 'services.php?action=edit_medicine&id=' + id;
}
function deleteMedicine(id) {
    if (confirm('<?= t('confirm_delete_medicine') ?>')) {
        window.location = 'services.php?action=delete_medicine&id=' + id;
    }
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/main.js"></script>
</body>
</html>

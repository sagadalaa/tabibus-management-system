<?php
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/config/language.php';
require __DIR__ . '/../app/helpers/functions.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

// Check user role if needed, for example only admin/clinic admin can manage medics
// if ($_SESSION['user_role'] !== 'administrator' && $_SESSION['user_role'] !== 'clinic_admin') {
//     redirect('dashboard.php');
// }

$dir = ($lang === 'ar') ? 'rtl' : 'ltr';

// Placeholder array for medics. In a real scenario, fetch from the database.
$medics = [
    ['id' => 1, 'full_name' => 'Dr. Ahmed Ali', 'specialty' => 'Cardiologist', 'phone' => '123456789', 'email' => 'ahmed@example.com'],
    ['id' => 2, 'full_name' => 'Dr. Sara Hassan', 'specialty' => 'Dermatologist', 'phone' => '987654321', 'email' => 'sara@example.com']
];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - <?= t('medics') ?></title>
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
                <li class="nav-item"><a class="nav-link active" href="medics.php"><?= t('medics') ?></a></li>
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
        <h2 class="mb-3 mb-md-0"><?= t('medics') ?></h2>
        <form class="d-flex" method="get" action="">
            <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="<?= t('search_medics') ?>" aria-label="Search" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            <button class="btn btn-sm btn-primary" type="submit"><?= t('search') ?></button>
        </form>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addMedicModal"><?= t('add_medic') ?></button>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><?= t('full_name') ?></th>
                            <th><?= t('specialty') ?></th>
                            <th><?= t('phone_number') ?></th>
                            <th><?= t('email') ?></th>
                            <th><?= t('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($medics) > 0): ?>
                            <?php foreach ($medics as $medic): ?>
                            <tr>
                                <td><?= htmlspecialchars($medic['full_name']) ?></td>
                                <td><?= htmlspecialchars($medic['specialty']) ?></td>
                                <td><?= htmlspecialchars($medic['phone']) ?></td>
                                <td><?= htmlspecialchars($medic['email']) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editMedic(<?= $medic['id'] ?>)"><?= t('edit') ?></button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteMedic(<?= $medic['id'] ?>)"><?= t('delete') ?></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center text-muted"><?= t('no_medics_found') ?></td></tr>
                        <?php endif; ?>
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

<!-- Add Medic Modal -->
<div class="modal fade" id="addMedicModal" tabindex="-1" aria-labelledby="addMedicLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= t('add_medic') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= t('close') ?>"></button>
            </div>
            <div class="modal-body">
                <form action="medics.php?action=add_medic" method="post">
                    <div class="mb-3">
                        <label for="full_name" class="form-label"><?= t('full_name') ?></label>
                        <input type="text" name="full_name" id="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="specialty" class="form-label"><?= t('specialty') ?></label>
                        <input type="text" name="specialty" id="specialty" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label"><?= t('phone_number') ?></label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><?= t('email') ?></label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success"><?= t('add_medic') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Action Scripts -->
<script>
function editMedic(id) {
    window.location = 'medics.php?action=edit_medic&id=' + id;
}
function deleteMedic(id) {
    if (confirm('<?= t('confirm_delete_medic') ?>')) {
        window.location = 'medics.php?action=delete_medic&id=' + id;
    }
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/main.js"></script>
</body>
</html>
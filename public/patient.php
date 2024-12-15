<?php
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/config/language.php';
require __DIR__ . '/../app/helpers/functions.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

$dir = ($lang === 'ar') ? 'rtl' : 'ltr';

// Example: In a real scenario, you'd fetch patients from the database using PatientModel
// $patients = $patientModel->getAllPatients($_SESSION['clinic_id']);
$patients = [
    [
        'id' => 1,
        'full_name' => 'John Doe',
        'phone' => '1234567890',
        'gender' => 'male',
        'age' => 30
    ],
    [
        'id' => 2,
        'full_name' => 'Jane Smith',
        'phone' => '0987654321',
        'gender' => 'female',
        'age' => 25
    ]
];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - <?= t('patients') ?></title>
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
                <li class="nav-item"><a class="nav-link active" href="patient.php"><?= t('patients') ?></a></li>
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
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <h2 class="mb-3 mb-md-0"><?= t('patients') ?></h2>
        <div class="d-flex gap-2">
            <!-- Search Bar -->
            <form class="d-flex" method="get" action="">
                <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="<?= t('search_patient') ?>" aria-label="Search" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                <button class="btn btn-sm btn-primary" type="submit"><?= t('search') ?></button>
            </form>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addPatientModal"><?= t('add_patient') ?></button>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><?= t('full_name') ?></th>
                            <th><?= t('phone_number') ?></th>
                            <th><?= t('gender') ?></th>
                            <th><?= t('age') ?></th>
                            <th><?= t('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($patients) > 0): ?>
                            <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td><?= htmlspecialchars($patient['full_name']) ?></td>
                                <td><?= htmlspecialchars($patient['phone']) ?></td>
                                <td><?= t($patient['gender']) ?></td>
                                <td><?= htmlspecialchars($patient['age']) ?></td>
                                <td>
                                    <div class="btn-group dropstart">
                                        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?= t('action') ?>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="appointments.php?action=add&patient_id=<?= $patient['id'] ?>"><?= t('add_appointment') ?></a></li>
                                            <li><a class="dropdown-item" href="patient.php?action=history&patient_id=<?= $patient['id'] ?>"><?= t('show_history') ?></a></li>
                                            <li><a class="dropdown-item" href="patient.php?action=files&patient_id=<?= $patient['id'] ?>"><?= t('patient_files') ?></a></li>
                                        </ul>
                                    </div>
                                    <button class="btn btn-sm btn-warning" onclick="window.location='patient.php?action=edit&patient_id=<?= $patient['id'] ?>'"><?= t('edit') ?></button>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $patient['id'] ?>)"><?= t('delete') ?></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted"><?= t('no_patients_found') ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Pagination (if needed) -->
    <!--
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item disabled"><a class="page-link" href="#"><?= t('previous') ?></a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#"><?= t('next') ?></a></li>
      </ul>
    </nav>
    -->
</div>

<footer class="mt-auto bg-white py-4 border-top">
    <div class="container text-center">
        <p class="mb-0 text-muted">&copy; <?= date('Y') ?> <?= SITE_NAME ?>. <?= t('all_rights_reserved') ?></p>
    </div>
</footer>

<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= t('add_patient') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= t('close') ?>"></button>
            </div>
            <div class="modal-body">
                <form action="patient.php?action=add" method="post">
                    <div class="mb-3">
                        <label for="full_name" class="form-label"><?= t('full_name') ?></label>
                        <input type="text" name="full_name" id="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label"><?= t('date_of_birth') ?></label>
                        <input type="date" name="dob" id="dob" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label"><?= t('gender') ?></label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="male"><?= t('male') ?></option>
                            <option value="female"><?= t('female') ?></option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label"><?= t('phone_number') ?></label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label"><?= t('address') ?></label>
                        <textarea name="address" id="address" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label"><?= t('city') ?></label>
                        <select name="city" id="city" class="form-select" required>
                            <!-- Populate cities of Iraq -->
                            <option value="Baghdad">Baghdad</option>
                            <option value="Basra">Basra</option>
                            <option value="Mosul">Mosul</option>
                            <!-- Add more cities as needed -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success"><?= t('add_patient') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Delete Script -->
<script>
function confirmDelete(patientId) {
    if (confirm('<?= t('confirm_delete_patient') ?>')) {
        window.location = 'patient.php?action=delete&patient_id=' + patientId;
    }
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/main.js"></script>
</body>
</html>

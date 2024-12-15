<?php
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/config/language.php';
require __DIR__ . '/../app/helpers/functions.php';
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    redirect('dashboard.php');
}

// Handle form submission (pseudo-code)
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Placeholder: Here you would authenticate using UserModel and AuthController logic
    // $user = $userModel->getUserByUsername($username);
    // if ($user && password_verify($password, $user['password']) && $user['status'] === 'active') {
    //     $_SESSION['user_id'] = $user['id'];
    //     $_SESSION['user_role'] = $user['role'];
    //     $_SESSION['clinic_id'] = $user['clinic_id'];
    //     redirect('dashboard.php');
    // } else {
    //     $error = t('invalid_credentials_or_inactive');
    // }

    // For demonstration, let's say the credentials are incorrect:
    $error = t('invalid_credentials_or_inactive');
}

$dir = ($lang === 'ar') ? 'rtl' : 'ltr';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - <?= t('login') ?></title>
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main Styles -->
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
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/images/logo.png" alt="Clinic Logo" width="40" height="40" class="me-2">
            <span><?= SITE_NAME ?></span>
        </a>
        <div>
            <!-- Language Toggle -->
            <a href="?lang=en" class="btn btn-sm btn-outline-primary me-1">EN</a>
            <a href="?lang=ar" class="btn btn-sm btn-outline-primary">AR</a>
        </div>
    </div>
</nav>

<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card shadow-sm" style="max-width: 400px; width: 100%;">
        <div class="card-body p-4">
            <h3 class="card-title mb-4"><?= t('login') ?></h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label"><?= t('username') ?></label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="<?= t('enter_username') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><?= t('password') ?></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="<?= t('enter_password') ?>" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="#forgot-password-modal" data-bs-toggle="modal" class="text-muted small"><?= t('forgot_password') ?></a>
                    <button type="submit" class="btn btn-primary"><?= t('login') ?></button>
                </div>
            </form>

            <hr>
            <p class="text-center mb-0"><?= t('no_account') ?> <a href="#register-modal" data-bs-toggle="modal"><?= t('register_here') ?></a></p>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgot-password-modal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= t('forgot_password') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= t('close') ?>"></button>
            </div>
            <div class="modal-body">
                <p><?= t('reset_password_instructions') ?></p>
                <form action="forgot_password.php" method="post">
                    <div class="mb-3">
                        <label for="reset-email" class="form-label"><?= t('email_address') ?></label>
                        <input type="email" name="email" id="reset-email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= t('send_reset_link') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="register-modal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= t('register') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= t('close') ?>"></button>
            </div>
            <div class="modal-body">
                <p><?= t('register_intro') ?></p>
                <form action="login.php?action=register" method="post">
                    <div class="mb-3">
                        <label for="reg-fullname" class="form-label"><?= t('full_name') ?></label>
                        <input type="text" name="full_name" id="reg-fullname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="reg-clinicname" class="form-label"><?= t('clinic_name') ?></label>
                        <input type="text" name="clinic_name" id="reg-clinicname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="reg-phone" class="form-label"><?= t('phone_number') ?></label>
                        <input type="text" name="phone" id="reg-phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="reg-username" class="form-label"><?= t('username') ?></label>
                        <input type="text" name="username" id="reg-username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="reg-password" class="form-label"><?= t('password') ?></label>
                        <input type="password" name="password" id="reg-password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success"><?= t('register') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<footer class="mt-auto bg-white py-4 border-top">
    <div class="container text-center">
        <p class="mb-0 text-muted">&copy; <?= date('Y') ?> <?= SITE_NAME ?>. <?= t('all_rights_reserved') ?></p>
    </div>
</footer>

<!-- Bootstrap JS (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/js/main.js"></script>
</body>
</html>

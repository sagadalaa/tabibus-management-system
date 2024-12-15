<?php
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/config/language.php';
require __DIR__ . '/../app/helpers/functions.php'; 
session_start();

if (isset($_SESSION['user_id'])) {
    // If the user is already logged in, redirect to dashboard
    redirect('dashboard.php');
}

// Determine text direction for language
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
    <!-- Optional: Add a favicon -->
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

<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold mb-4"><?= t('welcome_to') ?> <?= SITE_NAME ?></h1>
            <p class="lead text-muted"><?= t('clinic_management_intro') ?></p>
            <p class="mb-4"><?= t('clinic_management_description') ?></p>
            <div class="d-flex gap-2">
                <a href="login.php" class="btn btn-primary btn-lg"><?= t('login') ?></a>
                <a href="login.php#register" class="btn btn-outline-secondary btn-lg"><?= t('register') ?></a>
            </div>
        </div>
        <div class="col-md-6 text-center mt-4 mt-md-0">
            <!-- A placeholder illustration or hero image -->
            <img src="assets/images/hero-illustration.png" alt="Clinic Illustration" class="img-fluid" style="max-height: 400px;">
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

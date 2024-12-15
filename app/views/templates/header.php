<?php
/**
 * Header Template for Clinic Management System
 * Author: Your Name
 * Description: Contains the common header structure for all pages.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$userRole = $_SESSION['user_role'] ?? 'guest';
$userName = $_SESSION['user_name'] ?? 'Guest';
$clinicName = $_SESSION['clinic_name'] ?? 'Your Clinic';
$locale = $_SESSION['locale'] ?? 'en';
?>

<!DOCTYPE html>
<html lang="<?= $locale ?>" dir="<?= $locale === 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <?php if ($locale === 'ar'): ?>
        <link rel="stylesheet" href="/assets/css/theme-ar.css">
    <?php endif; ?>
    <title><?= $clinicName ?> | <?= ucfirst($userRole) ?> Dashboard</title>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="/dashboard">
                    <img src="/assets/images/logo.png" alt="<?= $clinicName ?>" class="logo-image">
                </a>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="/dashboard"><?= t('Dashboard') ?></a></li>
                    <?php if ($userRole === 'clinic_admin' || $userRole === 'receptionist'): ?>
                        <li><a href="/patients"><?= t('Patients') ?></a></li>
                        <li><a href="/appointments"><?= t('Appointments') ?></a></li>
                    <?php endif; ?>
                    <?php if ($userRole === 'clinic_admin'): ?>
                        <li><a href="/services"><?= t('Services') ?></a></li>
                        <li><a href="/reports"><?= t('Reports') ?></a></li>
                        <li><a href="/system"><?= t('System') ?></a></li>
                        <li><a href="/messages"><?= t('Messages') ?></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="user-menu">
                <span><?= t('Welcome') ?>, <?= htmlspecialchars($userName) ?></span>
                <div class="dropdown">
                    <button class="dropdown-toggle"><?= t('Account') ?></button>
                    <ul class="dropdown-menu">
                        <li><a href="/profile"><?= t('Profile') ?></a></li>
                        <li><a href="/settings"><?= t('Settings') ?></a></li>
                        <li><a href="/logout"><?= t('Logout') ?></a></li>
                    </ul>
                </div>
                <button class="language-toggle" onclick="toggleLanguage()"><?= $locale === 'ar' ? 'English' : 'العربية' ?></button>
            </div>
        </div>
    </header>
    <main class="main-content">

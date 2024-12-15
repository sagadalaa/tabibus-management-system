<?php
/**
 * Navbar Template for Clinic Management System
 * Author: Your Name
 * Description: Contains the top navigation bar structure with role-based actions.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$userName = $_SESSION['user_name'] ?? 'Guest';
$clinicName = $_SESSION['clinic_name'] ?? 'Your Clinic';
$locale = $_SESSION['locale'] ?? 'en';
?>

<nav class="navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <div class="navbar-logo">
            <a href="/dashboard">
                <img src="/assets/images/logo.png" alt="Clinic Logo">
            </a>
        </div>

        <!-- Search Bar -->
        <div class="navbar-search">
            <form action="/search" method="GET" class="search-form">
                <input type="text" name="q" placeholder="<?= t('Search...') ?>" class="search-input">
                <button type="submit" class="search-button">
                    <i class="icon icon-search"></i>
                </button>
            </form>
        </div>

        <!-- User Menu -->
        <div class="navbar-user">
            <span class="user-greeting"><?= t('Hello') ?>, <?= htmlspecialchars($userName) ?></span>
            <div class="dropdown">
                <button class="dropdown-toggle">
                    <i class="icon icon-user"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="/profile"><i class="icon icon-profile"></i> <?= t('Profile') ?></a></li>
                    <li><a href="/settings"><i class="icon icon-settings"></i> <?= t('Settings') ?></a></li>
                    <li><a href="/logout"><i class="icon icon-logout"></i> <?= t('Logout') ?></a></li>
                </ul>
            </div>
        </div>

        <!-- Notifications -->
        <div class="navbar-notifications">
            <button class="notifications-toggle">
                <i class="icon icon-bell"></i>
                <span class="notification-count">3</span>
            </button>
            <div class="notifications-dropdown">
                <ul>
                    <li>
                        <a href="/notifications/1">
                            <p><?= t('New appointment scheduled.') ?></p>
                            <span class="notification-time"><?= t('2 mins ago') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="/notifications/2">
                            <p><?= t('Patient record updated.') ?></p>
                            <span class="notification-time"><?= t('10 mins ago') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="/notifications/3">
                            <p><?= t('Subscription will expire soon.') ?></p>
                            <span class="notification-time"><?= t('1 day ago') ?></span>
                        </a>
                    </li>
                </ul>
                <a href="/notifications" class="view-all"><?= t('View All Notifications') ?></a>
            </div>
        </div>

        <!-- Language Toggle -->
        <div class="navbar-language">
            <button onclick="toggleLanguage()" class="language-toggle">
                <?= $locale === 'ar' ? 'English' : 'العربية' ?>
            </button>
        </div>
    </div>
</nav>

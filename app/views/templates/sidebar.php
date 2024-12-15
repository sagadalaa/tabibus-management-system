<?php
/**
 * Sidebar Template for Clinic Management System
 * Author: Your Name
 * Description: Contains the sidebar navigation structure with role-based access.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$userRole = $_SESSION['user_role'] ?? 'guest';
?>

<aside class="sidebar">
    <div class="sidebar-header">
        <a href="/dashboard" class="sidebar-logo">
            <img src="/assets/images/logo.png" alt="Clinic Logo">
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li>
                <a href="/dashboard" class="<?= isActive('/dashboard') ?>">
                    <i class="icon icon-dashboard"></i>
                    <?= t('Dashboard') ?>
                </a>
            </li>
            <?php if ($userRole === 'clinic_admin' || $userRole === 'receptionist'): ?>
                <li>
                    <a href="/patients" class="<?= isActive('/patients') ?>">
                        <i class="icon icon-patients"></i>
                        <?= t('Patients') ?>
                    </a>
                </li>
                <li>
                    <a href="/appointments" class="<?= isActive('/appointments') ?>">
                        <i class="icon icon-appointments"></i>
                        <?= t('Appointments') ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($userRole === 'clinic_admin'): ?>
                <li>
                    <a href="/services" class="<?= isActive('/services') ?>">
                        <i class="icon icon-services"></i>
                        <?= t('Services') ?>
                    </a>
                </li>
                <li>
                    <a href="/reports" class="<?= isActive('/reports') ?>">
                        <i class="icon icon-reports"></i>
                        <?= t('Reports') ?>
                    </a>
                </li>
                <li>
                    <a href="/system" class="<?= isActive('/system') ?>">
                        <i class="icon icon-system"></i>
                        <?= t('System') ?>
                    </a>
                </li>
                <li>
                    <a href="/messages" class="<?= isActive('/messages') ?>">
                        <i class="icon icon-messages"></i>
                        <?= t('Messages') ?>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <a href="/profile" class="profile-link">
            <i class="icon icon-user"></i>
            <?= t('Profile') ?>
        </a>
        <a href="/logout" class="logout-link">
            <i class="icon icon-logout"></i>
            <?= t('Logout') ?>
        </a>
    </div>
</aside>

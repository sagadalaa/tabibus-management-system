<?php
/**
 * Subscription Details Template for Clinic Management System
 * Author: Your Name
 * Description: Displays and manages subscription details for the clinic.
 */

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Example subscription data (replace with dynamic backend data)
$subscriptionDetails = $subscriptionDetails ?? [
    'subscription_type' => 'Premium',
    'start_date' => '2024-01-01',
    'expiry_date' => '2025-01-01',
    'price' => '1200.00',
    'status' => 'Active',
    'paid' => true,
];

// Display optional error or success messages
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Subscription Details - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Subscription Details | Clinic Management System</title>
</head>
<body>
    <?php include __DIR__ . '/../templates/header.php'; ?>
    <?php include __DIR__ . '/../templates/sidebar.php'; ?>

    <main class="subscription-container">
        <div class="subscription-header">
            <h1><?= t('Subscription Details') ?></h1>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="subscription-details">
            <div class="detail-item">
                <strong><?= t('Subscription Type:') ?></strong>
                <span><?= htmlspecialchars($subscriptionDetails['subscription_type']) ?></span>
            </div>
            <div class="detail-item">
                <strong><?= t('Start Date:') ?></strong>
                <span><?= htmlspecialchars($subscriptionDetails['start_date']) ?></span>
            </div>
            <div class="detail-item">
                <strong><?= t('Expiry Date:') ?></strong>
                <span><?= htmlspecialchars($subscriptionDetails['expiry_date']) ?></span>
            </div>
            <div class="detail-item">
                <strong><?= t('Price:') ?></strong>
                <span>$<?= htmlspecialchars($subscriptionDetails['price']) ?></span>
            </div>
            <div class="detail-item">
                <strong><?= t('Status:') ?></strong>
                <span><?= htmlspecialchars($subscriptionDetails['status']) ?></span>
            </div>
            <div class="detail-item">
                <strong><?= t('Paid:') ?></strong>
                <span><?= $subscriptionDetails['paid'] ? t('Yes') : t('No') ?></span>
            </div>
        </div>

        <div class="actions">
            <?php if (!$subscriptionDetails['paid']): ?>
                <a href="/system/subscription/pay" class="btn btn-primary"><?= t('Pay Now') ?></a>
            <?php endif; ?>
            <a href="/system/subscription/renew" class="btn btn-secondary"><?= t('Renew Subscription') ?></a>
        </div>
    </main>

    <script src="/assets/js/main.js"></script>
</body>
</html>

<?php
/**
 * Forgot Password Template for Clinic Management System
 * Author: Your Name
 * Description: Displays the forgot password form for users to reset their password.
 */

session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard');
    exit;
}

// Display error or success messages (optional)
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Forgot Password - Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Forgot Password | Clinic Management System</title>
</head>
<body>
    <div class="forgot-password-container">
        <div class="forgot-password-card">
            <div class="forgot-password-header">
                <img src="/assets/images/logo.png" alt="Clinic Logo" class="forgot-password-logo">
                <h1>Forgot Your Password?</h1>
                <p>Enter your registered email address, and we'll send you instructions to reset your password.</p>
            </div>
            <form action="/forgot-password/send-link" method="POST" class="forgot-password-form">
                <?php if ($error): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="success-message">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email address" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Send Reset Link</button>
                </div>
                <div class="forgot-password-links">
                    <a href="/login">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
    <script src="/assets/js/main.js"></script>
</body>
</html>

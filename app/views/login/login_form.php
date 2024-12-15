<?php
/**
 * Login Form Template for Clinic Management System
 * Author: Your Name
 * Description: Displays the login form for users to access the system.
 */

session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard');
    exit;
}

// Display error message if login fails (optional)
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login to Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Login | Clinic Management System</title>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="/assets/images/logo.png" alt="Clinic Logo" class="login-logo">
                <h1>Welcome Back</h1>
                <p>Please login to continue</p>
            </div>
            <form action="/login/authenticate" method="POST" class="login-form">
                <?php if ($error): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <div class="login-links">
                    <a href="/forgot-password">Forgot your password?</a>
                    <a href="/register">Don't have an account? Register</a>
                </div>
            </form>
        </div>
    </div>
    <script src="/assets/js/main.js"></script>
</body>
</html>

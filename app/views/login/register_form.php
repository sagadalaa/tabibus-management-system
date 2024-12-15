<?php
/**
 * Register Form Template for Clinic Management System
 * Author: Your Name
 * Description: Displays the registration form for new users.
 */

session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard');
    exit;
}

// Display error message if registration fails (optional)
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Register for Clinic Management System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <title>Register | Clinic Management System</title>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <img src="/assets/images/logo.png" alt="Clinic Logo" class="register-logo">
                <h1>Create an Account</h1>
                <p>Join our system to manage your clinic seamlessly</p>
            </div>
            <form action="/register/submit" method="POST" class="register-form">
                <?php if ($error): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" name="full_name" id="full_name" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="clinic_name">Clinic Name</label>
                    <input type="text" name="clinic_name" id="clinic_name" placeholder="Enter your clinic name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" name="phone" id="phone" placeholder="Enter your phone number" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Choose a username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Choose a strong password" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
                <div class="register-links">
                    <a href="/login">Already have an account? Login</a>
                </div>
            </form>
        </div>
    </div>
    <script src="/assets/js/main.js"></script>
</body>
</html>

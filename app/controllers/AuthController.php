<?php
/**
 * AuthController for Clinic Management System
 * Author: Your Name
 * Description: Handles user authentication (login, logout, registration, password reset).
 */

require_once __DIR__ . '/../models/UserModel.php';

class AuthController
{
    /**
     * Show the login form
     */
    public function loginForm()
    {
        require __DIR__ . '/../../views/login/login_form.php';
    }

    /**
     * Handle the login process
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // Set session variables
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];

                // Redirect based on role
                redirect('/dashboard');
            } else {
                $error = 'Invalid username or password.';
                require __DIR__ . '/../../views/login/login_form.php';
            }
        }
    }

    /**
     * Logout the user
     */
    public function logout()
    {
        session_start();
        session_destroy();
        redirect('/login');
    }

    /**
     * Show the registration form
     */
    public function registerForm()
    {
        require __DIR__ . '/../../views/login/register_form.php';
    }

    /**
     * Handle the registration process
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = trim($_POST['full_name']);
            $clinicName = trim($_POST['clinic_name']);
            $phone = trim($_POST['phone']);
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            // Validate inputs
            if (empty($fullName) || empty($clinicName) || empty($phone) || empty($username) || empty($password)) {
                $error = 'All fields are required.';
                require __DIR__ . '/../../views/login/register_form.php';
                return;
            }

            $userModel = new UserModel();

            // Check if username already exists
            if ($userModel->findByUsername($username)) {
                $error = 'Username already exists.';
                require __DIR__ . '/../../views/login/register_form.php';
                return;
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Register the user (set status as pending by default)
            $userModel->create([
                'full_name' => $fullName,
                'clinic_name' => $clinicName,
                'phone' => $phone,
                'username' => $username,
                'password' => $hashedPassword,
                'role' => 'clinic_admin',
                'status' => 'pending',
            ]);

            // Redirect to login page with success message
            $success = 'Registration successful. Please wait for admin approval.';
            require __DIR__ . '/../../views/login/login_form.php';
        }
    }

    /**
     * Show the forgot password form
     */
    public function forgotPasswordForm()
    {
        require __DIR__ . '/../../views/login/forgot_password.php';
    }

    /**
     * Handle password reset process
     */
    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $userModel = new UserModel();
            $user = $userModel->findByUsername($username);

            if ($user) {
                // Generate a reset token (for simplicity, using a random string)
                $resetToken = bin2hex(random_bytes(16));
                $userModel->setResetToken($user['id'], $resetToken);

                // Send reset email (placeholder)
                $resetLink = 'https://yourdomain.com/reset-password?token=' . $resetToken;
                mail($user['email'], 'Password Reset', "Click here to reset your password: $resetLink");

                $success = 'Password reset instructions sent to your email.';
            } else {
                $error = 'User not found.';
            }

            require __DIR__ . '/../../views/login/forgot_password.php';
        }
    }
}

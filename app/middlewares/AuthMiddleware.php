<?php
/**
 * Authentication Middleware for Clinic Management System
 * Author: Your Name
 * Description: Ensures only authenticated users can access specific resources.
 */

namespace App\Middlewares;

use App\Helpers\AuthHelper;

class AuthMiddleware
{
    /**
     * Enforce Authentication
     * Ensures the user is logged in before accessing the resource.
     *
     * @param string $redirectPath Path to redirect unauthenticated users (default: '/login.php').
     */
    public static function enforce(string $redirectPath = '/login.php'): void
    {
        // Check if the user is logged in
        if (!AuthHelper::is_logged_in()) {
            AuthHelper::redirect($redirectPath);
        }
    }

    /**
     * Redirect Authenticated Users
     * Redirects logged-in users to a specified path if they attempt to access guest-only routes (e.g., login page).
     *
     * @param string $redirectPath Path to redirect authenticated users (default: '/dashboard.php').
     */
    public static function redirectIfAuthenticated(string $redirectPath = '/dashboard.php'): void
    {
        // Check if the user is logged in
        if (AuthHelper::is_logged_in()) {
            AuthHelper::redirect($redirectPath);
        }
    }
}

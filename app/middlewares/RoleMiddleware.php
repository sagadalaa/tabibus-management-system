<?php
/**
 * Role Middleware for Clinic Management System
 * Author: Your Name
 * Description: Handles role-based access control for secured routes.
 */

namespace App\Middlewares;

use App\Helpers\AuthHelper;

class RoleMiddleware
{
    /**
     * Enforce Role Access
     * Checks if the logged-in user has the required role(s) to access the resource.
     *
     * @param array|string $roles Role(s) required to access the resource.
     * @param string $redirectPath Path to redirect unauthorized users (default: '/unauthorized.php').
     */
    public static function enforce($roles, string $redirectPath = '/unauthorized.php'): void
    {
        // Ensure the user is logged in
        if (!AuthHelper::is_logged_in()) {
            AuthHelper::redirect('/login.php');
        }

        // Convert single role to an array
        if (is_string($roles)) {
            $roles = [$roles];
        }

        // Check if the user is authorized
        if (!AuthHelper::is_authorized($roles)) {
            AuthHelper::redirect($redirectPath);
        }
    }
}

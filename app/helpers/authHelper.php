<?php
/**
 * Authentication Helper for Clinic Management System
 * Author: Your Name
 * Description: Provides functions for user authentication, session handling, and role-based access control.
 */

if (!function_exists('is_logged_in')) {
    /**
     * Check if User is Logged In
     * Verifies if a user session exists.
     *
     * @return bool True if logged in, false otherwise.
     */
    function is_logged_in(): bool
    {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('require_login')) {
    /**
     * Require Login
     * Redirects to the login page if the user is not logged in.
     */
    function require_login(): void
    {
        if (!is_logged_in()) {
            redirect('/login.php');
        }
    }
}

if (!function_exists('get_current_user')) {
    /**
     * Get Current User
     * Fetches the logged-in user's details from the session.
     *
     * @return array|null User details or null if not logged in.
     */
    function get_current_user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
}

if (!function_exists('login_user')) {
    /**
     * Login User
     * Logs in a user by setting session variables.
     *
     * @param array $user User details to store in the session.
     */
    function login_user(array $user): void
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'], // Example roles: 'admin', 'doctor', 'receptionist'
        ];
    }
}

if (!function_exists('logout_user')) {
    /**
     * Logout User
     * Clears the user session to log out the user.
     */
    function logout_user(): void
    {
        session_unset();
        session_destroy();
    }
}

if (!function_exists('has_role')) {
    /**
     * Check User Role
     * Verifies if the logged-in user has a specific role.
     *
     * @param string $role Role to check (e.g., 'admin', 'doctor').
     * @return bool True if the user has the role, false otherwise.
     */
    function has_role(string $role): bool
    {
        $currentUser = get_current_user();
        return $currentUser && $currentUser['role'] === $role;
    }
}

if (!function_exists('require_role')) {
    /**
     * Require Specific Role
     * Redirects to an unauthorized page if the user does not have the required role.
     *
     * @param string $role Role to enforce.
     */
    function require_role(string $role): void
    {
        if (!has_role($role)) {
            redirect('/unauthorized.php');
        }
    }
}

if (!function_exists('is_authorized')) {
    /**
     * Check Authorization
     * Checks if the logged-in user has any of the specified roles.
     *
     * @param array $roles Array of roles to check.
     * @return bool True if the user has one of the roles, false otherwise.
     */
    function is_authorized(array $roles): bool
    {
        $currentUser = get_current_user();
        return $currentUser && in_array($currentUser['role'], $roles, true);
    }
}

if (!function_exists('require_authorization')) {
    /**
     * Require Authorization
     * Redirects to an unauthorized page if the user is not authorized.
     *
     * @param array $roles Array of roles to enforce.
     */
    function require_authorization(array $roles): void
    {
        if (!is_authorized($roles)) {
            redirect('/unauthorized.php');
        }
    }
}

if (!function_exists('set_flash_message')) {
    /**
     * Set Flash Message
     * Stores a flash message in the session.
     *
     * @param string $type Message type (e.g., 'success', 'error').
     * @param string $message Message content.
     */
    function set_flash_message(string $type, string $message): void
    {
        $_SESSION['flash_messages'][$type] = $message;
    }
}

if (!function_exists('get_flash_messages')) {
    /**
     * Get Flash Messages
     * Retrieves and clears all flash messages from the session.
     *
     * @return array Associative array of flash messages.
     */
    function get_flash_messages(): array
    {
        $messages = $_SESSION['flash_messages'] ?? [];
        unset($_SESSION['flash_messages']);
        return $messages;
    }
}

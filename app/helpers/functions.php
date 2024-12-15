<?php
/**
 * Utility Functions for Clinic Management System
 * Author: Your Name
 * Description: Provides reusable helper functions for the system.
 */

if (!function_exists('t')) {
    /**
     * Translation Function
     * Translates the given text to the current system language.
     * 
     * @param string $text Text to translate.
     * @return string Translated text.
     */
    function t(string $text): string
    {
        // Example translation logic (replace with actual language file logic)
        $translations = [
            'en' => [
                'Hello' => 'Hello',
                'Save Changes' => 'Save Changes',
            ],
            'ar' => [
                'Hello' => 'مرحبا',
                'Save Changes' => 'حفظ التغييرات',
            ],
        ];

        $language = $_SESSION['language'] ?? 'en';
        return $translations[$language][$text] ?? $text;
    }
}

if (!function_exists('sanitize_input')) {
    /**
     * Sanitize Input
     * Cleans user input to prevent XSS and other attacks.
     * 
     * @param string $input Input string to sanitize.
     * @return string Sanitized string.
     */
    function sanitize_input(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('generate_csrf_token')) {
    /**
     * Generate CSRF Token
     * Creates a CSRF token and stores it in the session.
     * 
     * @return string CSRF token.
     */
    function generate_csrf_token(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('validate_csrf_token')) {
    /**
     * Validate CSRF Token
     * Checks if the provided CSRF token matches the session token.
     * 
     * @param string $token CSRF token to validate.
     * @return bool True if valid, false otherwise.
     */
    function validate_csrf_token(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect
     * Redirects the user to a given URL.
     * 
     * @param string $url URL to redirect to.
     */
    function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}

if (!function_exists('format_date')) {
    /**
     * Format Date
     * Formats a given date to a readable format.
     * 
     * @param string $date Date string to format.
     * @param string $format Date format (default: 'Y-m-d H:i:s').
     * @return string Formatted date.
     */
    function format_date(string $date, string $format = 'Y-m-d H:i:s'): string
    {
        $timestamp = strtotime($date);
        return $timestamp ? date($format, $timestamp) : $date;
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format Currency
     * Formats a given amount to the system's currency format.
     * 
     * @param float $amount Amount to format.
     * @param string $currency Currency symbol (default: '$').
     * @return string Formatted currency string.
     */
    function format_currency(float $amount, string $currency = '$'): string
    {
        return $currency . number_format($amount, 2);
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * Get Client IP Address
     * Returns the client's IP address.
     * 
     * @return string Client IP address.
     */
    function get_client_ip(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    }
}

if (!function_exists('generate_random_string')) {
    /**
     * Generate Random String
     * Generates a random alphanumeric string.
     * 
     * @param int $length Length of the string (default: 16).
     * @return string Random string.
     */
    function generate_random_string(int $length = 16): string
    {
        return bin2hex(random_bytes($length / 2));
    }
}

<?php
/**
 * Validation Helper for Clinic Management System
 * Author: Your Name
 * Description: Provides reusable functions for validating user input and data.
 */

if (!function_exists('is_valid_email')) {
    /**
     * Validate Email Address
     * Checks if the provided email address is valid.
     *
     * @param string $email Email address to validate.
     * @return bool True if valid, false otherwise.
     */
    function is_valid_email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (!function_exists('is_valid_phone')) {
    /**
     * Validate Phone Number
     * Checks if the provided phone number matches a valid pattern.
     *
     * @param string $phone Phone number to validate.
     * @return bool True if valid, false otherwise.
     */
    function is_valid_phone(string $phone): bool
    {
        return preg_match('/^\+?[0-9]{7,15}$/', $phone) === 1;
    }
}

if (!function_exists('is_non_empty')) {
    /**
     * Check Non-Empty String
     * Ensures the input string is not empty or whitespace.
     *
     * @param string $input Input string to check.
     * @return bool True if non-empty, false otherwise.
     */
    function is_non_empty(string $input): bool
    {
        return trim($input) !== '';
    }
}

if (!function_exists('is_valid_date')) {
    /**
     * Validate Date
     * Checks if the provided date matches a valid format.
     *
     * @param string $date Date to validate.
     * @param string $format Expected date format (default: 'Y-m-d').
     * @return bool True if valid, false otherwise.
     */
    function is_valid_date(string $date, string $format = 'Y-m-d'): bool
    {
        $dateTime = DateTime::createFromFormat($format, $date);
        return $dateTime && $dateTime->format($format) === $date;
    }
}

if (!function_exists('is_valid_number')) {
    /**
     * Validate Number
     * Checks if the input is a valid number within a specified range.
     *
     * @param mixed $number Number to validate.
     * @param float|null $min Minimum value (optional).
     * @param float|null $max Maximum value (optional).
     * @return bool True if valid, false otherwise.
     */
    function is_valid_number($number, ?float $min = null, ?float $max = null): bool
    {
        if (!is_numeric($number)) {
            return false;
        }
        $number = (float)$number;
        if ($min !== null && $number < $min) {
            return false;
        }
        if ($max !== null && $number > $max) {
            return false;
        }
        return true;
    }
}

if (!function_exists('validate_password')) {
    /**
     * Validate Password
     * Checks if a password meets minimum strength requirements.
     *
     * @param string $password Password to validate.
     * @return bool True if valid, false otherwise.
     */
    function validate_password(string $password): bool
    {
        $hasUppercase = preg_match('/[A-Z]/', $password);
        $hasLowercase = preg_match('/[a-z]/', $password);
        $hasNumber = preg_match('/[0-9]/', $password);
        $hasSpecialChar = preg_match('/[\W]/', $password); // Special characters
        $isLongEnough = strlen($password) >= 8;

        return $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar && $isLongEnough;
    }
}

if (!function_exists('is_valid_url')) {
    /**
     * Validate URL
     * Checks if the provided string is a valid URL.
     *
     * @param string $url URL to validate.
     * @return bool True if valid, false otherwise.
     */
    function is_valid_url(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}

if (!function_exists('has_valid_length')) {
    /**
     * Validate String Length
     * Checks if the string length falls within a specified range.
     *
     * @param string $input Input string to validate.
     * @param int|null $min Minimum length (optional).
     * @param int|null $max Maximum length (optional).
     * @return bool True if valid, false otherwise.
     */
    function has_valid_length(string $input, ?int $min = null, ?int $max = null): bool
    {
        $length = strlen($input);
        if ($min !== null && $length < $min) {
            return false;
        }
        if ($max !== null && $length > $max) {
            return false;
        }
        return true;
    }
}

if (!function_exists('validate_csrf_token')) {
    /**
     * Validate CSRF Token
     * Checks if the provided CSRF token matches the one stored in the session.
     *
     * @param string $token CSRF token to validate.
     * @return bool True if valid, false otherwise.
     */
    function validate_csrf_token(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}

if (!function_exists('is_valid_username')) {
    /**
     * Validate Username
     * Ensures the username is alphanumeric and within a valid length range.
     *
     * @param string $username Username to validate.
     * @return bool True if valid, false otherwise.
     */
    function is_valid_username(string $username): bool
    {
        return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username) === 1;
    }
}

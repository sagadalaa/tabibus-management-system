<?php
/**
 * Configuration File for Clinic Management System
 * Author: Your Name
 * Description: Centralized configuration for the application.
 */

return [
    // General Site Settings
    'site' => [
        'name' => 'Clinic Management System', // Site name used in titles and branding
        'url' => 'https://yourdomain.com',    // Base URL of your site
        'timezone' => 'Asia/Baghdad',         // Default timezone
        'locale' => 'en',                     // Default language (en, ar, etc.)
    ],

    // Database Configuration
    'database' => [
        'host' => '127.0.0.1',    // Database host (e.g., localhost)
        'port' => '3306',         // Database port
        'name' => 'clinic_db',    // Database name
        'user' => 'db_user',      // Database username
        'password' => 'db_password', // Database password
        'charset' => 'utf8mb4',   // Character set for the database connection
    ],

    // Security Settings
    'security' => [
        'encryption_key' => 'your-encryption-key-here', // Replace with a strong, random key
        'session_lifetime' => 1440, // Session lifetime in seconds (default is 24 minutes)
        'csrf_token_lifetime' => 3600, // CSRF token lifetime in seconds
        'password_cost' => 12, // Bcrypt cost factor for password hashing
    ],

    // Paths
    'paths' => [
        'base' => realpath(__DIR__ . '/../../'), // Base directory of the project
        'public' => realpath(__DIR__ . '/../../public'), // Public directory
        'storage' => realpath(__DIR__ . '/../../storage'), // Storage directory
        'logs' => realpath(__DIR__ . '/../../storage/logs'), // Logs directory
    ],

    // Email Configuration (Optional)
    'email' => [
        'smtp_host' => 'smtp.mailtrap.io', // SMTP host
        'smtp_port' => 2525,              // SMTP port
        'smtp_user' => 'your-smtp-user',  // SMTP username
        'smtp_password' => 'your-smtp-password', // SMTP password
        'from_email' => 'noreply@yourdomain.com', // Default "From" email address
        'from_name' => 'Clinic Management System', // Default "From" name
    ],

    // Environment
    'environment' => [
        'debug' => true,  // Enable/disable debug mode
        'log_errors' => true, // Log errors to storage/logs
    ],

    // API Settings (if applicable)
    'api' => [
        'base_url' => 'https://api.yourdomain.com', // Base URL for API endpoints
        'token' => 'your-api-token-here', // Authentication token for API requests
    ],
];

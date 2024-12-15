<?php
/**
 * Language Configuration for Clinic Management System
 * Author: Your Name
 * Description: Handles language selection and loading of language files.
 */

// Load configuration
$config = require __DIR__ . '/config.php';

// Default language from configuration
$defaultLanguage = $config['site']['locale'] ?? 'en';

// Available languages (extend as needed)
$availableLanguages = ['en', 'ar'];

// Get the selected language from query parameters, session, or fallback to default
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? $defaultLanguage;

// Validate the selected language
if (!in_array($lang, $availableLanguages)) {
    $lang = $defaultLanguage;
}

// Save the selected language in the session
session_start();
$_SESSION['lang'] = $lang;

// Set the direction based on the selected language
$dir = ($lang === 'ar') ? 'rtl' : 'ltr';

// Load the language file
$languageFile = __DIR__ . "/../../languages/{$lang}.php";
if (!file_exists($languageFile)) {
    die("Language file not found: {$languageFile}");
}

$translations = require $languageFile;

/**
 * Translation Helper Function
 * 
 * @param string $key The translation key to retrieve.
 * @param array $replacements Optional replacements for placeholders in the translation string.
 * @return string The translated string or the key if not found.
 */
function t($key, $replacements = [])
{
    global $translations;

    // Get the translation or fallback to the key
    $text = $translations[$key] ?? $key;

    // Replace placeholders with values if provided
    foreach ($replacements as $placeholder => $value) {
        $text = str_replace("{{{$placeholder}}}", $value, $text);
    }

    return $text;
}

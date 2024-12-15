<?php
/**
 * Language Helper for Clinic Management System
 * Author: Your Name
 * Description: Provides functionality for handling multi-language support in the system.
 */

if (!function_exists('load_language')) {
    /**
     * Load Language File
     * Loads the language file based on the selected language.
     *
     * @param string $language Language code (e.g., 'en', 'ar').
     * @return array Associative array of translations.
     */
    function load_language(string $language): array
    {
        $defaultLanguage = 'en'; // Fallback language
        $languagePath = __DIR__ . "/../languages/{$language}.php";

        if (file_exists($languagePath)) {
            return include $languagePath;
        }

        // Load the default language if the specified one doesn't exist
        $defaultPath = __DIR__ . "/../languages/{$defaultLanguage}.php";
        if (file_exists($defaultPath)) {
            return include $defaultPath;
        }

        // Return an empty array if no language files are found
        return [];
    }
}

if (!function_exists('t')) {
    /**
     * Translation Function
     * Retrieves the translated string for the given key.
     *
     * @param string $key The translation key.
     * @param array $params Optional parameters for placeholders in the string.
     * @return string Translated string or the key if not found.
     */
    function t(string $key, array $params = []): string
    {
        static $translations = null;

        // Load the translations only once
        if ($translations === null) {
            $selectedLanguage = $_SESSION['language'] ?? 'en';
            $translations = load_language($selectedLanguage);
        }

        // Fetch the translation or fallback to the key itself
        $translation = $translations[$key] ?? $key;

        // Replace placeholders if parameters are provided
        foreach ($params as $placeholder => $value) {
            $translation = str_replace("{{{$placeholder}}}", $value, $translation);
        }

        return $translation;
    }
}

if (!function_exists('set_language')) {
    /**
     * Set Language
     * Sets the current language for the session.
     *
     * @param string $language Language code (e.g., 'en', 'ar').
     */
    function set_language(string $language): void
    {
        $_SESSION['language'] = $language;
    }
}

if (!function_exists('get_available_languages')) {
    /**
     * Get Available Languages
     * Retrieves the list of available language files in the system.
     *
     * @return array List of available languages as language codes.
     */
    function get_available_languages(): array
    {
        $languages = [];
        $languagePath = __DIR__ . '/../languages/';
        foreach (glob($languagePath . '*.php') as $file) {
            $languages[] = basename($file, '.php');
        }
        return $languages;
    }
}

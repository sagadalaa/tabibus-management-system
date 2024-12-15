/* ==========================================================================
   Language Toggle JS for Clinic Management System
   Author: Your Name
   Description: Handles language switching logic and, optionally, persists user preference.
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function() {
    // Optional: If you want to restore the previously chosen language from localStorage:
    // const savedLang = localStorage.getItem('preferredLang');
    // if (savedLang && !location.search.includes(`lang=`)) {
    //     // Redirect to the same page with the chosen lang parameter if none is present
    //     const url = new URL(window.location);
    //     url.searchParams.set('lang', savedLang);
    //     window.location.replace(url.toString());
    // }

    // Find all language toggle links
    const langLinks = document.querySelectorAll('a[href*="lang="]');
    langLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // If you want to store user preference:
            // const urlParams = new URLSearchParams(this.href.split('?')[1]);
            // const chosenLang = urlParams.get('lang');
            // localStorage.setItem('preferredLang', chosenLang);

            // No need to prevent default if you rely on server to reload page in the chosen language.
            // If you did want a smooth client-side language switch (not recommended without full i18n support),
            // you could intercept the click and handle language changes dynamically.
        });
    });
});

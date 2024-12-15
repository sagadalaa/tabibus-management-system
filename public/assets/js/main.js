/* ==========================================================================
   Main JS for Clinic Management System
   Author: Your Name
   Description: Handles common interactive tasks, event listeners, and dynamic UI updates.
   ========================================================================== */

/**
 * Document Ready
 * We ensure DOM is ready before attaching event handlers.
 */
document.addEventListener('DOMContentLoaded', function() {

    // Example: Handle language toggle links if needed
    // If you have language links like ?lang=en or ?lang=ar, no extra JS might be needed.
    // But if you want to store preferences in LocalStorage or apply language dynamically,
    // you could do it here.
    const langLinks = document.querySelectorAll('a[href*="lang="]');
    langLinks.forEach(link => {
        link.addEventListener('click', function() {
            // If you wanted to save language choice in localStorage:
            // const urlParams = new URLSearchParams(this.href.split('?')[1]);
            // const chosenLang = urlParams.get('lang');
            // localStorage.setItem('preferredLang', chosenLang);
        });
    });

    // Example: Add event listeners for dynamic features
    // E.g., printing a receipt or confirming actions
    const printButtons = document.querySelectorAll('.print-btn');
    printButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            window.print();
        });
    });

    // Example: AJAX call for updating charts or appointments (placeholder)
    // In a real scenario, you might fetch data via AJAX and update the DOM or a chart.
    // fetch('/api/appointments')
    //     .then(response => response.json())
    //     .then(data => {
    //         // Update chart with new data
    //     });

    // Example: Collapsible sidebar or additional UI interaction
    // If you have a sidebar that needs toggling:
    // const sidebarToggle = document.getElementById('sidebarToggle');
    // const sidebar = document.getElementById('sidebar');
    // if (sidebarToggle && sidebar) {
    //     sidebarToggle.addEventListener('click', function() {
    //         sidebar.classList.toggle('collapsed');
    //     });
    // }

    // Example: Form validation messages or tooltips (Bootstrap)
    // Use Bootstrap’s tooltips or popovers if needed
    // const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    // const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    //   return new bootstrap.Tooltip(tooltipTriggerEl);
    // });

    // Example: Handle modal actions if needed
    // const myModal = new bootstrap.Modal(document.getElementById('myModal'), {});
    // document.getElementById('openModalBtn').addEventListener('click', () => {
    //     myModal.show();
    // });

});

/**
 * Optional global functions
 * Here you can define some utility functions used across the app.
 */

/**
 * confirmAction(message, callback)
 * A simple wrapper to confirm user actions.
 * @param {string} message - Confirmation prompt message.
 * @param {function} callback - Function to execute if user confirms.
 */
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

/**
 * showNotification(type, message)
 * Display a notification or alert to the user.
 * Types: success, error, info, warning
 * This is just a placeholder. You could implement a toast notification using Bootstrap’s Toasts.
 */
function showNotification(type, message) {
    // Placeholder: Console log for now.
    console.log(`[${type.toUpperCase()}] ${message}`);
    // In a real scenario, create a toast element and show it:
    // const toastEl = document.getElementById('myToast');
    // toastEl.querySelector('.toast-body').innerText = message;
    // const toast = new bootstrap.Toast(toastEl);
    // toast.show();
}

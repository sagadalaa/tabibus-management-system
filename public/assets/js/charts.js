/* ==========================================================================
   Charts JS for Clinic Management System
   Author: Your Name
   Description: Handles initialization and updates for Chart.js charts used across the system.
   ========================================================================== */

/**
 * Global Chart.js Configuration
 */
Chart.defaults.font.family = '"Helvetica Neue", Arial, sans-serif';
Chart.defaults.font.size = 14;
Chart.defaults.color = '#495057';
Chart.defaults.borderColor = '#dee2e6';
Chart.defaults.plugins.legend.labels.usePointStyle = true;

/**
 * initializeChart(ctx, type, data, options)
 * A helper function to initialize a new Chart instance.
 *
 * @param {HTMLCanvasElement} ctx - The canvas context to render the chart.
 * @param {string} type - The type of chart (e.g., 'line', 'bar', 'pie').
 * @param {Object} data - The data object for Chart.js (labels, datasets).
 * @param {Object} [options={}] - Optional chart configuration options.
 * @returns {Chart} - The created Chart.js instance.
 */
function initializeChart(ctx, type, data, options = {}) {
    return new Chart(ctx, {
        type: type,
        data: data,
        options: Object.assign({
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e9ecef'
                    }
                },
                x: {
                    grid: {
                        color: '#f8f9fa'
                    }
                }
            }
        }, options)
    });
}

/**
 * updateChartData(chart, newData)
 * Update the chart with new data and re-render it.
 *
 * @param {Chart} chart - The existing Chart.js instance.
 * @param {Object} newData - The new data object (labels, datasets).
 */
function updateChartData(chart, newData) {
    chart.data = newData;
    chart.update();
}

/**
 * fetchChartData(url, params, callback)
 * A placeholder function to fetch data from an API endpoint and invoke a callback to handle it.
 *
 * @param {string} url - The endpoint URL to fetch chart data from.
 * @param {Object} params - Optional parameters for the request.
 * @param {function} callback - A function to handle the fetched data.
 */
function fetchChartData(url, params, callback) {
    // Example: Using Fetch API
    // Adjust headers or request parameters as needed.
    const query = new URLSearchParams(params).toString();
    fetch(`${url}?${query}`)
        .then(response => response.json())
        .then(data => {
            if (callback && typeof callback === 'function') {
                callback(data);
            }
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
        });
}

/**
 * Example usage:
 *
 * const ctx = document.getElementById('appointmentsChart').getContext('2d');
 * let appointmentsChart = initializeChart(ctx, 'line', {
 *     labels: ['Jan', 'Feb', 'Mar', 'Apr'],
 *     datasets: [{
 *         label: 'Appointments',
 *         data: [30, 45, 25, 50],
 *         borderColor: 'rgba(54,162,235,1)',
 *         borderWidth: 2,
 *         fill: false,
 *         tension: 0.3
 *     }]
 * });
 *
 * // Later, if you want to update the chart:
 * fetchChartData('/api/report_data', {type: 'appointments', timeframe: 'monthly'}, (data) => {
 *     // Assuming 'data' has 'labels' and 'datasets' formatted for Chart.js
 *     updateChartData(appointmentsChart, data);
 * });
 */

 // Add more helper functions if you have multiple charts or specific formatting requirements.

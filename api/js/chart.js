// Wrap your existing chart code
function initCharts() {
    // Doughnut chart
    const doughnutData = {
        labels: ['Red', 'Blue', 'Yellow'],
        datasets: [{
            label: 'Dataset',
            data: [300, 50, 100],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
        }]
    };
    const doughnutConfig = { type: 'doughnut', data: doughnutData };
    new Chart(document.getElementById('myDoughnutChart'), doughnutConfig);

    // Line chart
    const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
    const data = {
        labels: labels,
        datasets: [{
            label: 'My First Dataset',
            data: [65, 59, 80, 81, 56, 55, 40],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    };
    const config = { type: 'line', data: data };
    new Chart(document.getElementById('myChart'), config);
}

// Function to show dashboard and init charts
function showDashboard() {
    const dashboard = document.getElementById('dashboard_template');
    dashboard.classList.remove('d-none'); // Show the dashboard
    initCharts(); // Initialize charts AFTER it's visible
}

// Wait until DOM is loaded
document.addEventListener("DOMContentLoaded", function() {
    showDashboard(); // Call this here
});

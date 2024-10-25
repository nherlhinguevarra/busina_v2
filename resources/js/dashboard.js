const { jsPDF } = window.jspdf;

let vehicleChart, violationChart;
let fetchedData = null; // Global variable to store fetched data

// Function to update the Vehicle Chart
function updateVehicleChart(timeframe, data) {
    const vehicleLabels = (timeframe === 'week') ?
        data.vehiclesPerWeek.map(item => new Date(item.week.toString().slice(0, 4), 0, (item.week.toString().slice(4) - 1) * 7 + 1).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })) :
        data.vehiclesPerMonth.map(item => `${item.year}-${item.month}`);
    
    const vehicleCounts = (timeframe === 'week') ? 
        data.vehiclesPerWeek.map(item => item.count) : 
        data.vehiclesPerMonth.map(item => item.count);

    if (vehicleChart) {
        vehicleChart.destroy();
    }
    const vehicleCtx = document.getElementById('vehicleChart').getContext('2d');
    vehicleChart = new Chart(vehicleCtx, {
        type: 'line',
        data: {
            labels: vehicleLabels,
            datasets: [{
                label: 'Vehicles Registered',
                data: vehicleCounts,
                borderColor: '#09b3e4',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false // Hide legend
                }
            },
        
        }
    });
}

// Function to update the Violation Chart
function updateViolationChart(timeframe, data) {
    const violationLabels = (timeframe === 'week') ?
        data.violationsPerWeek.map(item => new Date(item.week.toString().slice(0, 4), 0, (item.week.toString().slice(4) - 1) * 7 + 1).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })) :
        data.violationsPerMonth.map(item => `${item.year}-${item.month}`);

    const violationCounts = (timeframe === 'week') ? 
        data.violationsPerWeek.map(item => item.count) : 
        data.violationsPerMonth.map(item => item.count);

    if (violationChart) {
        violationChart.destroy();
    }
    const violationCtx = document.getElementById('violationChart').getContext('2d');
    violationChart = new Chart(violationCtx, {
        type: 'line',
        data: {
            labels: violationLabels,
            datasets: [{
                label: 'Violations Reported',
                data: violationCounts,
                borderColor: '#f2752b',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false // Hide legend
                }
            },
        }
    });
}

// Fetch data once and store it globally
fetch('/get-vehicle-violation-data')
    .then(response => response.json())
    .then(data => {
        fetchedData = data; // Store fetched data globally

        // Initialize both charts with weekly data by default
        updateVehicleChart('week', data); 
        updateViolationChart('week', data);

        // Update the Vehicle Chart when the vehicle timeframe dropdown changes
        document.getElementById('vehicleTimeframe').addEventListener('change', function () {
            const selectedTimeframe = this.value;
            updateVehicleChart(selectedTimeframe, fetchedData);
        });

        // Update the Violation Chart when the violation timeframe dropdown changes
        document.getElementById('violationTimeframe').addEventListener('change', function () {
            const selectedTimeframe = this.value;
            updateViolationChart(selectedTimeframe, fetchedData);
        });
    });

// Function to download the chart as a PDF
function downloadChartAsPDF(chartId, chartType, timeframe, data, filename) {
    // Get the currently selected timeframe from the dropdown
    const vehicleTimeframe = document.getElementById('vehicleTimeframe').value;
    const violationTimeframe = document.getElementById('violationTimeframe').value;
    const selectedTimeframe = chartId === 'vehicleChart' ? vehicleTimeframe : violationTimeframe;

    const canvas = document.getElementById(chartId);
    const chartImage = canvas.toDataURL('image/png');
    const doc = new jsPDF();

    // Add header
    doc.setFontSize(12);
    doc.text("Bicol University", 10, 10);
    doc.text("Motorpool Section", 10, 15);
    doc.text("Rizal St., Legazpi City, Albay", 10, 20);
    
    // Prepare dates for report title
    let startDate, endDate, dateRangeText;

    if (selectedTimeframe === 'week') {
        const weekData = chartId === 'vehicleChart' ? data.vehiclesPerWeek : data.violationsPerWeek;
        if (weekData.length > 0) {
            // Get first and last week data
            const firstWeek = weekData[0].week.toString();
            const lastWeek = weekData[weekData.length - 1].week.toString();

            // Calculate dates for first week
            const firstYear = parseInt(firstWeek.slice(0, 4));
            const firstWeekNum = parseInt(firstWeek.slice(4));
            startDate = new Date(firstYear, 0, (firstWeekNum - 1) * 7 + 1);

            // Calculate dates for last week
            const lastYear = parseInt(lastWeek.slice(0, 4));
            const lastWeekNum = parseInt(lastWeek.slice(4));
            endDate = new Date(lastYear, 0, lastWeekNum * 7);

            // Format for display
            dateRangeText = `${startDate.toLocaleDateString('en-US', { 
                month: 'long', 
                day: 'numeric' 
            })} to ${endDate.toLocaleDateString('en-US', { 
                month: 'long', 
                day: 'numeric',
                year: 'numeric'
            })}`;
        }
    } else {
        const monthData = chartId === 'vehicleChart' ? data.vehiclesPerMonth : data.violationsPerMonth;
        if (monthData.length > 0) {
            // Get first and last month data
            const firstMonth = monthData[0];
            const lastMonth = monthData[monthData.length - 1];

            startDate = new Date(firstMonth.year, firstMonth.month - 1);
            endDate = new Date(lastMonth.year, lastMonth.month - 1);

            // Format for display
            dateRangeText = `${startDate.toLocaleDateString('en-US', { 
                month: 'long',
                year: 'numeric'
            })} to ${endDate.toLocaleDateString('en-US', { 
                month: 'long',
                year: 'numeric'
            })}`;
        }
    }

    // Add report title with date range
    doc.setFontSize(16);
    const reportTitle = `Report on the ${chartType} from ${dateRangeText}`;
    doc.text(reportTitle, 10, 30);
    
    // Add the chart image
    doc.addImage(chartImage, 'PNG', 10, 40, 180, 80);

    // Format filename date
    const formattedStartDate = startDate.toLocaleDateString('en-US', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).replace(/\//g, '-');
    
    const formattedEndDate = endDate.toLocaleDateString('en-US', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).replace(/\//g, '-');

    const fileName = `${filename}_${formattedStartDate}_to_${formattedEndDate}.pdf`;
    doc.save(fileName);
}

// Update the event listeners to pass the correct timeframe
document.getElementById('downloadRegistrationPDF').addEventListener('click', function() {
    const selectedTimeframe = document.getElementById('vehicleTimeframe').value;
    downloadChartAsPDF('vehicleChart', 'Vehicles Registered', selectedTimeframe, fetchedData, 'Registration_Report');
});

document.getElementById('downloadViolationPDF').addEventListener('click', function() {
    const selectedTimeframe = document.getElementById('violationTimeframe').value;
    downloadChartAsPDF('violationChart', 'Violations Reported', selectedTimeframe, fetchedData, 'Violation_Report');
});


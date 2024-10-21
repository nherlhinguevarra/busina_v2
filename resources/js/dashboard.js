let vehicleChart, violationChart;
    // Function to update the Vehicle Chart
    function updateVehicleChart(timeframe, data) {
        const vehicleLabels = (timeframe === 'week') ? 
            data.vehiclesPerWeek.map(item => `Week ${item.week}`) : 
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
                        onClick: null  // Disable click events on the legend labels
                    }
                }
            }
        });
    }

    // Function to update the Violation Chart
    function updateViolationChart(timeframe, data) {
        const violationLabels = (timeframe === 'week') ? 
            data.violationsPerWeek.map(item => `Week ${item.week}`) : 
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
                        onClick: null  // Disable click events on the legend labels
                    }
                }
            }
        });
    }

    // Fetch data once
    fetch('/get-vehicle-violation-data')
        .then(response => response.json())
        .then(data => {
            // Initialize both charts with weekly data by default
            updateVehicleChart('week', data);
            updateViolationChart('week', data);

            // Update the Vehicle Chart when the vehicle timeframe dropdown changes
            document.getElementById('vehicleTimeframe').addEventListener('change', function () {
                const selectedTimeframe = this.value;
                updateVehicleChart(selectedTimeframe, data);
            });

            // Update the Violation Chart when the violation timeframe dropdown changes
            document.getElementById('violationTimeframe').addEventListener('change', function () {
                const selectedTimeframe = this.value;
                updateViolationChart(selectedTimeframe, data);
            });
        });
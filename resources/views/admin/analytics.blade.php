<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Office Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1e3a8a;
            --secondary-blue: #3b82f6;
            --light-blue: #dbeafe;
            --bg-gray: #f8fafc;
            --card-white: #ffffff;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --border-color: #e2e8f0;
            --success-green: #10b981;
            --danger-red: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gray);
            color: var(--text-dark);
        }

        .dashboard-header {
            background: var(--card-white);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin: 0;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--secondary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .main-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--primary-blue);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            color: white;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .stat-sparkline {
            height: 40px;
            opacity: 0.6;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card-modern {
            background: var(--card-white);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header-clean {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title-clean {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .view-all-link {
            font-size: 0.875rem;
            color: var(--secondary-blue);
            text-decoration: none;
            font-weight: 500;
        }

        .view-all-link:hover {
            text-decoration: underline;
        }

        .card-body-clean {
            padding: 1.5rem;
        }

        .chart-wrapper {
            height: 300px;
            position: relative;
        }

        .map-card {
            grid-column: span 4;
        }

        .population-card {
            grid-column: span 4;
        }

        .immunization-card {
            grid-column: span 4;
        }

        .full-width-card {
            grid-column: span 12;
        }

        .half-width-card {
            grid-column: span 6;
        }

        .map-image-wrapper {
            width: 100%;
            height: 300px;
            position: relative;
            cursor: pointer;
            overflow: hidden;
            border-radius: 8px;
        }

        .map-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .map-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            color: white;
            padding: 1rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .stats-row {
                grid-template-columns: 1fr;
            }

            .content-grid > * {
                grid-column: span 12 !important;
            }

            .dashboard-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-header">
        <h1 class="dashboard-title">CITY HEALTH OFFICE ACTIVITY OVERVIEW</h1>
    </div>

    <div class="main-container">
        <!-- Stats Cards Row -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Total Population</div>
                <div class="stat-value" id="stat-population">--</div>
                <svg class="stat-sparkline" viewBox="0 0 100 40">
                    <polyline points="0,30 20,25 40,20 60,15 80,10 100,8" 
                              fill="none" stroke="white" stroke-width="2"/>
                </svg>
            </div>

            <div class="stat-card">
                <div class="stat-label">Total Live Birth</div>
                <div class="stat-value" id="stat-births">--</div>
                <svg class="stat-sparkline" viewBox="0 0 100 40">
                    <polyline points="0,25 20,22 40,20 60,18 80,15 100,12" 
                              fill="none" stroke="white" stroke-width="2"/>
                </svg>
            </div>

            <div class="stat-card">
                <div class="stat-label">Total Deaths</div>
                <div class="stat-value" id="stat-deaths">--</div>
                <svg class="stat-sparkline" viewBox="0 0 100 40">
                    <polyline points="0,20 20,22 40,25 60,23 80,28 100,30" 
                              fill="none" stroke="white" stroke-width="2"/>
                </svg>
            </div>

            <div class="stat-card">
                <div class="stat-label">Admissions</div>
                <div class="stat-value" id="stat-admissions">--</div>
                <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem; flex-wrap: wrap;">
                    <span style="font-size: 0.75rem; opacity: 0.9;">Infectious</span>
                    <span style="font-size: 0.75rem; opacity: 0.9;">Deficiency</span>
                    <span style="font-size: 0.75rem; opacity: 0.9;">Social</span>
                </div>
            </div>
        </div>

        <!-- First Row of Cards -->
        <div class="content-grid">
            <div class="card-modern map-card">
                <div class="card-header-clean">
                    <h3 class="card-title-clean">Dagupan City Map</h3>
                </div>
                <div class="card-body-clean" style="padding: 0;">
                    <div class="map-image-wrapper" id="map-container">
                        <img src="https://www.dagupan.gov.ph/wp-content/uploads/2023/05/Dagupan-Map-e1684306560968.png"
                             alt="Dagupan City Map">
                        <div class="map-overlay" id="population-text">
                            City of Dagupan / Loading...
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-modern population-card">
                <div class="card-header-clean">
                    <h3 class="card-title-clean">Population per Barangay</h3>
                    <a href="#" class="view-all-link">All Barangay</a>
                </div>
                <div class="card-body-clean">
                    <div class="chart-wrapper">
                        <canvas id="populationChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="card-modern immunization-card">
                <div class="card-header-clean">
                    <h3 class="card-title-clean">Immunization Statistics</h3>
                </div>
                <div class="card-body-clean">
                    <div class="chart-wrapper">
                        <canvas id="immunizationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row of Cards -->
        <div class="content-grid">
            <div class="card-modern half-width-card">
                <div class="card-header-clean">
                    <h3 class="card-title-clean">Morbidity Statistics</h3>
                    <a href="#" class="view-all-link">View All</a>
                </div>
                <div class="card-body-clean">
                    <div class="chart-wrapper">
                        <canvas id="morbidityCasesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="card-modern half-width-card">
                <div class="card-header-clean">
                    <h3 class="card-title-clean">Mortality Statistics</h3>
                    <a href="#" class="view-all-link">View All</a>
                </div>
                <div class="card-body-clean">
                    <div class="chart-wrapper">
                        <canvas id="mortalityCasesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Birth and Death Rate Card -->
        <div class="content-grid">
            <div class="card-modern full-width-card">
                <div class="card-header-clean">
                    <h3 class="card-title-clean">Birth and Death Rate</h3>
                    <a href="#" class="view-all-link">View All</a>
                </div>
                <div class="card-body-clean">
                    <div class="chart-wrapper">
                        <canvas id="birthDeathChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal (unchanged) -->
    <div class="modal fade" id="barangayModal" tabindex="-1" aria-labelledby="barangayModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="barangayModalLabel">Barangay Population Statistics</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center" id="population-table">
                            <thead class="table-primary">
                                <tr>
                                    <th>Barangay</th>
                                    <th>Population</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Filled dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Load city-wide summary on page load
        fetch("{{ url('/dagupan-population') }}")
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("population-text").innerHTML =
                        `${data.city} / Population ${data.population.toLocaleString()} (${data.year})`;
                }
            })
            .catch(() => {
                document.getElementById("population-text").innerHTML =
                    "City of Dagupan / Population unavailable";
            });

        // Click map container to load barangay population
        document.getElementById("map-container").addEventListener("click", function () {
            fetch("{{ route('dagupan.barangays') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const tbody = document.querySelector("#population-table tbody");
                        tbody.innerHTML = "";

                        data.barangays.forEach(row => {
                            tbody.innerHTML += `
                                <tr>
                                    <td class="fw-semibold">${row.location}</td>
                                    <td>${row.population.toLocaleString()}</td>
                                    <td>${new Date(row.date).toLocaleDateString()}</td>
                                </tr>
                            `;
                        });

                        new bootstrap.Modal(document.getElementById("barangayModal")).show();
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Unable to load barangay population data.");
                });
        });

        document.addEventListener("DOMContentLoaded", function () {
            // Laravel Data
            let vitalStatisticsData = {!! json_encode($vitalStatisticsData) !!};
            let barangays = {!! json_encode($barangays) !!};
            let immunizationData = {!! json_encode($immunizationData) !!};
            let morbidityData = {!! json_encode($morbidityCases) !!};
            let mortalityData = {!! json_encode($mortalityCases) !!};

            let sortedVital = vitalStatisticsData.sort((a, b) => a.year - b.year);
            let sortedPopulation = barangays.sort((a, b) => new Date(a.date) - new Date(b.date));
            let totalPopulation = sortedPopulation.reduce((sum, item) => sum + parseInt(item.population), 0);

            // Update stat cards
            document.getElementById('stat-population').textContent = totalPopulation.toLocaleString();
            
            // Calculate sum of all births and deaths across all years
            let totalBirths = sortedVital.reduce((sum, item) => sum + parseInt(item.total_live_births), 0);
            let totalDeaths = sortedVital.reduce((sum, item) => sum + parseInt(item.total_deaths), 0);
            
            document.getElementById('stat-births').textContent = totalBirths.toLocaleString();
            document.getElementById('stat-deaths').textContent = totalDeaths.toLocaleString();
            
            // Calculate total admissions from morbidity data
            let totalAdmissions = morbidityData.reduce((sum, item) => sum + parseInt(item.male_count) + parseInt(item.female_count), 0);
            document.getElementById('stat-admissions').textContent = totalAdmissions.toLocaleString();

            // Population Chart (Donut)
            new Chart(document.getElementById("populationChart"), {
                type: "doughnut",
                data: {
                    labels: sortedPopulation.slice(0, 6).map(item => item.location || item.date),
                    datasets: [{
                        data: sortedPopulation.slice(0, 6).map(item => item.population),
                        backgroundColor: ['#3b82f6', '#06b6d4', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });

            // Birth / Death Chart
            new Chart(document.getElementById("birthDeathChart"), {
                type: "line",
                data: {
                    labels: sortedVital.map(item => item.year),
                    datasets: [
                        {
                            label: "Live Births",
                            borderColor: "#3b82f6",
                            backgroundColor: "rgba(59, 130, 246, 0.1)",
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            data: sortedVital.map(item => item.total_live_births)
                        },
                        {
                            label: "Total Deaths",
                            borderColor: "#a855f7",
                            backgroundColor: "rgba(168, 85, 247, 0.1)",
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            data: sortedVital.map(item => item.total_deaths)
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'top' } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Immunization Chart
            new Chart(document.getElementById("immunizationChart"), {
                type: "bar",
                data: {
                    labels: immunizationData.map(item => item.vaccine_name),
                    datasets: [
                        {
                            label: "Male",
                            backgroundColor: "#3b82f6",
                            data: immunizationData.map(item => item.male_vaccinated)
                        },
                        {
                            label: "Female",
                            backgroundColor: "#a78bfa",
                            data: immunizationData.map(item => item.female_vaccinated)
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Morbidity & Mortality Charts
            function getChronologicalTopCases(data) {
                return data.sort((a, b) => new Date(a.date) - new Date(b.date)).slice(0, 5);
            }

            function createChart(chartId, caseData) {
                new Chart(document.getElementById(chartId), {
                    type: "bar",
                    data: {
                        labels: caseData.map(c => c.case_name),
                        datasets: [
                            {
                                label: "Male",
                                backgroundColor: "#60a5fa",
                                data: caseData.map(c => c.male_count)
                            },
                            {
                                label: "Female",
                                backgroundColor: "#c084fc",
                                data: caseData.map(c => c.female_count)
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            createChart("morbidityCasesChart", getChronologicalTopCases(morbidityData));
            createChart("mortalityCasesChart", getChronologicalTopCases(mortalityData));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
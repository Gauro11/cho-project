



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
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --dark-bg: #0f0f23;
            --card-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.18);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --shadow-glow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            color: var(--text-primary);
            overflow-x: hidden;
        }

        .main-container {
            min-height: 100vh;
            backdrop-filter: blur(10px);
            background: rgba(15, 15, 35, 0.8);
        }

        .section-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            animation: fadeInUp 0.8s ease-out;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 10px;
        }

        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: var(--shadow-glow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .glass-card:hover::before {
            left: 100%;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(31, 38, 135, 0.5);
        }

        .card-header-modern {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .card-header-modern::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .card-title-modern {
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .card-subtitle-modern {
            opacity: 0.8;
            font-size: 0.9rem;
            font-weight: 300;
        }

        .chart-container {
            height: 300px !important;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 1rem;
            margin: 1rem;
            position: relative;
            overflow: hidden;
        }

        .chart-container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: var(--primary-gradient);
            border-radius: 17px;
            z-index: -1;
        }

        .map-container-modern {
    width: 100%;
    max-width: 800px;
    margin: 2rem auto;
    border-radius: 20px;
    overflow: hidden;
    background: var(--card-bg);
    backdrop-filter: blur(16px);
    border: 1px solid var(--glass-border);
    box-shadow: var(--shadow-glow);
    transition: all 0.3s ease;
    animation: slideInUp 1s ease-out;
    /* Make container height responsive */
    height: auto;
}

.map-container-modern:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 50px rgba(31, 38, 135, 0.6);
}

.map-image-modern {
    width: 100%;
    height: 100%; /* fill the container height */
    min-height: 400px; /* ensures a base height */
    object-fit: cover; /* fill container, crop if needed */
    display: block;
    transition: all 0.4s ease;
    filter: brightness(1.1) contrast(1.1);
}



        .map-title-modern {
            padding: 1.5rem;
            text-align: center;
            background: var(--primary-gradient);
            position: relative;
        }

        .map-title-modern h4 {
            margin: 0;
            color: white;
            font-weight: 600;
            font-size: 1.3rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        .floating-circle:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-circle:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-circle:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }

        .card-enter {
            animation: slideInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .card-enter:nth-child(1) {
            animation-delay: 0.1s;
        }

        .card-enter:nth-child(2) {
            animation-delay: 0.2s;
        }

        .card-enter:nth-child(3) {
            animation-delay: 0.3s;
        }

        .card-enter:nth-child(4) {
            animation-delay: 0.4s;
        }

        canvas {
            background-color: transparent !important;
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 1.5rem;
            }

            .map-image-modern {
                height: 250px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

 <div class="">
    <div class="container-fluid py-4">
        <h1 class="section-title pulse-animation">CITY HEALTH OFFICE STAFF OVERVIEW</h1>

        <div class="map-container-modern" id="map-container" style="cursor: pointer;">
            <img src="https://www.dagupan.gov.ph/wp-content/uploads/2023/05/Dagupan-Map-e1684306560968.png"
                 alt="Dagupan City Map"
                 class="map-image-modern">

            <div class="map-title-modern">
                <h4 id="population-text">🚩 City of Dagupan Map / Loading population...</h4>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
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

<script>
    // Load city-wide summary on page load
    fetch("{{ url('/dagupan-population') }}")
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById("population-text").innerHTML =
                    `🚩 ${data.city} Map / Population ${data.population.toLocaleString()} (${data.year})`;
            }
        })
        .catch(() => {
            document.getElementById("population-text").innerHTML =
                "🚩 City of Dagupan Map / Population unavailable";
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

                    // Show modal
                    new bootstrap.Modal(document.getElementById("barangayModal")).show();
                }
            })
            .catch(err => {
                console.error(err);
                alert("Unable to load barangay population data.");
            });
    });
</script>



            <h1 class="section-title">VITAL STATISTICS OVERVIEW</h1>

            <div class="stats-grid">
                <div class="glass-card card-enter">
                    <div class="card-header-modern">
                        <h5 class="card-title-modern">📈 Population Growth</h5>
                        <h6 class="card-subtitle-modern">Yearly total population statistics</h6>
                    </div>
                    <div class="chart-container">
                        <canvas id="populationChart"></canvas>
                    </div>
                </div>

                <div class="glass-card card-enter">
                    <div class="card-header-modern">
                        <h5 class="card-title-modern">👶 Birth and Death Rates</h5>
                        <h6 class="card-subtitle-modern">Live births vs. total deaths per year</h6>
                    </div>
                    <div class="chart-container">
                        <canvas id="birthDeathChart"></canvas>
                    </div>
                </div>
            </div>

            <h1 class="section-title">IMMUNIZATION OVERVIEW</h1>

            <div class="glass-card card-enter" style="margin: 2rem auto; max-width: 1000px;">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">🛡️ Immunization Statistics</h5>
                    <h6 class="card-subtitle-modern">Comparison of male and female vaccinations per vaccine type</h6>
                </div>
                <div class="chart-container">
                    <canvas id="immunizationChart"></canvas>
                </div>
            </div>

            <h1 class="section-title">MORBIDITY & MORTALITY OVERVIEW</h1>

            <div class="stats-grid">
                <div class="glass-card card-enter">
                    <div class="card-header-modern">
                        <h5 class="card-title-modern">😷 Morbidity Cases</h5>
                        <h6 class="card-subtitle-modern">Comparison of morbidity cases for male and female</h6>
                    </div>
                    <div class="chart-container">
                        <canvas id="morbidityCasesChart"></canvas>
                    </div>
                </div>

                <div class="glass-card card-enter">
                    <div class="card-header-modern">
                        <h5 class="card-title-modern">💀 Mortality Cases</h5>
                        <h6 class="card-subtitle-modern">Comparison of mortality cases for male and female</h6>
                    </div>
                    <div class="chart-container">
                        <canvas id="mortalityCasesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Scripts -->
   <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Laravel Data
        let vitalStatisticsData = {!! json_encode($vitalStatisticsData) !!};
        let barangays = {!! json_encode($barangays) !!};
        let immunizationData = {!! json_encode($immunizationData) !!};
        let morbidityData = {!! json_encode($morbidityCases) !!};
        let mortalityData = {!! json_encode($mortalityCases) !!};

        // Sort vital stats
        let sortedVital = vitalStatisticsData.sort((a, b) => a.year - b.year);

        // -------------------------
        // Population Chart (BOTH)
        // -------------------------
      new Chart(document.getElementById("populationChart"), {
    type: "line",
    data: {
        labels: sortedVital.map(item => item.date), // x-axis years
        datasets: [
            {
                label: "Total Population",
                borderColor: "#007bff",
                backgroundColor: "rgba(0, 123, 255, 0.2)",
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                data: barangays // total population from DB
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // ✅ important for responsiveness
        plugins: {
            legend: {
                position: "top",
                labels: {
                    font: {
                        size: 14
                    }
                }
            },
            title: {
                display: true,
                text: "Barangay Population Records",
                font: {
                    size: 18
                }
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: "Year"
                }
            },
            y: {
                title: {
                    display: true,
                    text: "Population"
                },
                beginAtZero: true
            }
        }
    }
    
});


        // -------------------------
        // Birth / Death Chart
        // -------------------------
        new Chart(document.getElementById("birthDeathChart"), {
            type: "line",
            data: {
                labels: sortedVital.map(item => item.year),
                datasets: [
                    {
                        label: "Live Births",
                        borderColor: "#2ECC71",
                        backgroundColor: "rgba(46,204,113,0.1)",
                        borderWidth: 3,
                        tension: 0.4,
                        pointBackgroundColor: "#2ECC71",
                        fill: true,
                        data: sortedVital.map(item => item.total_live_births)
                    },
                    {
                        label: "Total Deaths",
                        borderColor: "#E74C3C",
                        backgroundColor: "rgba(231,76,60,0.1)",
                        borderWidth: 3,
                        borderDash: [5, 5],
                        tension: 0.4,
                        pointBackgroundColor: "#E74C3C",
                        fill: true,
                        data: sortedVital.map(item => item.total_deaths)
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { labels: { color: "#333" } } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // -------------------------
        // Immunization Chart
        // -------------------------
        new Chart(document.getElementById("immunizationChart"), {
            type: "bar",
            data: {
                labels: immunizationData.map(item => item.vaccine_name),
                datasets: [
                    {
                        label: "Male",
                        backgroundColor: "#4A90E2",
                        data: immunizationData.map(item => item.male_vaccinated)
                    },
                    {
                        label: "Female",
                        backgroundColor: "#FF4081",
                        data: immunizationData.map(item => item.female_vaccinated)
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { stacked: false },
                    y: { beginAtZero: true, stacked: false }
                }
            }
        });

        // -------------------------
        // Morbidity & Mortality Charts
        // -------------------------
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
                            backgroundColor: "yellow",
                            data: caseData.map(c => c.male_count)
                        },
                        {
                            label: "Female",
                            backgroundColor: "violet",
                            data: caseData.map(c => c.female_count)
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { ticks: { color: "black" } },
                        y: { beginAtZero: true, ticks: { color: "black" } }
                    },
                    plugins: { legend: { labels: { color: "black" } } }
                }
            });
        }

        createChart("morbidityCasesChart", getChronologicalTopCases(morbidityData));
        createChart("mortalityCasesChart", getChronologicalTopCases(mortalityData));
    });
</script>


</body>

</html>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />



<div class="container-fluid p-0">

<div class="container-fluid">
    <h1 style="color:#000957;" class="h3 mb-3"><strong>CITY HEALTH OFFICE STAFF OVERVIEW</strong><br><strong></strong></h1>
    <div class="col-3 col-lg-3">
        <div class="card"></div>
    </div>

   
 <!-- Glowing Rectangle Dagupan Map Card -->
<div style="display: flex; justify-content: center; align-items: center; padding: 10px;">
    <div style="
        width: 400px;
        border-radius: 12px;
        overflow: hidden;
        background-color: #ffffff10;
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 20px rgba(0, 71, 171, 0.6), 0 0 40px rgba(0, 71, 171, 0.4);
        backdrop-filter: blur(10px);
        ">
        <img src="https://tools.paintmaps.com/og_image/map_cropping/4-1108697425-3.jpeg"
             alt="Dagupan City Map"
             style="width: 100%; height: auto; display: block; transition: transform 0.3s ease;"
             onmouseover="this.style.transform='scale(1.02)'"
             onmouseout="this.style.transform='scale(1)'">

        <div style="padding: 16px; text-align: center; background-color: rgba(255, 255, 255, 0.05);">
            <h4 style="
                margin: 0;
                color: #0047AB;
                font-weight: bold;
                font-size: 1.2rem;
                text-shadow: 0 0 10px rgba(0, 71, 171, 0.6);
            ">
                🚩 Dagupan City Map / Population 174,302
            </h4>
        </div>
    </div>
</div>


  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Office Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Minimize chart containers */
        .chart-container {
            height: 250px !important;
            background-color: white !important;
        }
        
        /* Ensure chart canvases have white backgrounds */
        canvas {
            background-color: white !important;
        }
        
        /* Make cards more compact */
        .card {
            margin-bottom: 15px;
        }
        
        .card-body {
            padding: 10px;
            background-color: white;
        }
    </style>
</head>
<body>



    <h1 style="color:#000957;" class="h3 mb-3"><strong>VITAL STATISTICS OVERVIEW</strong></h1>
    <div class="col-3 col-lg-3">
        <div class="card"></div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header" style="background-color: rgb(4, 150, 255); color: white;">
                    <h5 class="card-title">Population Growth</h5>
                    <h6 class="card-subtitle text-muted">Yearly total population statistics.</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="populationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header" style="background-color: rgb(4, 150, 255); color: white;">
                    <h5 class="card-title">Birth and Death Rates</h5>
                    <h6 class="card-subtitle text-muted">Live births vs. total deaths per year.</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="birthDeathChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 style="color:#000957;" class="h3 mt-4 mb-3"><strong>IMMUNIZATION</strong><br><strong>OVERVIEW</strong></h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background-color: rgb(4, 150, 255); color: white;">
                    <h5 class="card-title">Immunization Statistics</h5>
                    <h6 class="card-subtitle text-muted">Comparison of male and female vaccinations per vaccine type.</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="immunizationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 style="color:#000957;" class="h3 mt-4 mb-3"><strong>MORBIDITY & MORTALITY OVERVIEW</strong></h1>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header" style="background-color: rgb(4, 150, 255); color: white;">
                    <h5 class="card-title">Morbidity Cases</h5>
                    <h6 class="card-subtitle text-muted">Comparison of morbidity cases for male and female.</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="morbidityCasesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header" style="background-color: rgba(4, 150, 255, 0.87); color: white;">
                    <h5 class="card-title">Mortality Cases</h5>
                    <h6 class="card-subtitle text-muted">Comparison of mortality cases for male and female.</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="mortalityCasesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<!-- Scripts -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let vitalStatisticsData = {!! json_encode($vitalStatisticsData) !!};
        let sortedData = vitalStatisticsData.sort((a, b) => a.year - b.year);

        new Chart(document.getElementById("populationChart"), {
            type: "line",
            data: {
                labels: sortedData.map(item => item.year),
                datasets: [{
                    label: "Total Population",
                    borderColor: "#4A90E2",
                    borderWidth: 2,
                    fill: false,
                    data: sortedData.map(item => item.total_population)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });

        new Chart(document.getElementById("birthDeathChart"), {
            type: "line",
            data: {
                labels: sortedData.map(item => item.year),
                datasets: [
                    {
                        label: "Live Births",
                        borderColor: "#2ECC71",
                        borderWidth: 3,
                        pointStyle: 'circle',
                        pointRadius: 5,
                        fill: false,
                        data: sortedData.map(item => item.total_live_births)
                    },
                    {
                        label: "Total Deaths",
                        borderColor: "#E74C3C",
                        borderWidth: 2,
                        borderDash: [5, 5],
                        pointStyle: 'rect',
                        pointRadius: 5,
                        fill: false,
                        data: sortedData.map(item => item.total_deaths)
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });

        new Chart(document.getElementById("immunizationChart"), {
            type: "bar",
            data: {
                labels: {!! json_encode($immunizationData->pluck('vaccine_name')) !!},
                datasets: [
                    {
                        label: "Male",
                        backgroundColor: "#4A90E2",
                        data: {!! json_encode($immunizationData->pluck('male_vaccinated')) !!}
                    },
                    {
                        label: "Female",
                        backgroundColor: "#FF4081",
                        data: {!! json_encode($immunizationData->pluck('female_vaccinated')) !!}
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { stacked: true },
                    y: { beginAtZero: true, stacked: false }
                }
            }
        });

        const morbidityData = {!! json_encode($morbidityCases) !!};
        const mortalityData = {!! json_encode($mortalityCases) !!};

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
                    plugins: {
                        legend: { labels: { color: "black" } }
                    }
                }
            });
        }

        createChart("morbidityCasesChart", getChronologicalTopCases(morbidityData));
        createChart("mortalityCasesChart", getChronologicalTopCases(mortalityData));
    });
</script>

</body>
</html>
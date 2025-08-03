<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    .population-label {
        font-size: 14px;
        color: red;
        font-weight: bold;
        text-align: center;
    }

    .chart-container {
        background-color: white !important;
        padding: 20px;
        border-radius: 10px;
    }

    #philippinesMap {
        height: 500px;
        width: 100%;
        border-radius: 10px;
        border: 2px solid #0047AB;
    }

    .map-title-box {
        background-color: #0047AB;
        color: white;
        padding: 12px 20px;
        font-size: 20px;
        font-weight: bold;
        border-radius: 6px;
        display: inline-block;
        margin-top: 30px;
        margin-bottom: 15px;
    }
</style>

<div class="container-fluid p-0">

    <h1 style="color:#000957;" class="h3 mb-3"><strong>CITY HEALTH OFFICE STAFF</strong><br><strong>OVERVIEW</strong></h1>
    <div class="col-3 col-lg-3">
        <div class="card"></div>
    </div>

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
                    <canvas id="populationChart"></canvas>
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
                    <canvas id="birthDeathChart"></canvas>
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
                    <canvas id="immunizationChart"></canvas>
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
                    <canvas id="morbidityCasesChart"></canvas>
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
                    <canvas id="mortalityCasesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Title Box -->
    <div class="map-title-box">Dagupan City (Ilocos Region)</div>

    <!-- Leaflet Map -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="philippinesMap"></div>
                </div>
            </div>
        </div>
    </div>
</div>

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

        // === MAP SECTION ===
        var map = L.map('philippinesMap').setView([16.0431, 120.3331], 13);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://carto.com/">CARTO</a> contributors'
        }).addTo(map);

        L.marker([16.0431, 120.3331]).addTo(map)
            .bindPopup("Dagupan City<br>Population: 174,302")
            .openPopup();

        // Population label (red text on map)
        L.marker([16.0415, 120.3350], {
            icon: L.divIcon({
                className: 'population-label',
                html: 'Population: 174,302',
                iconSize: [150, 40]
            })
        }).addTo(map);

        const dagupanBoundary = {
            "type": "Feature",
            "properties": { "name": "Dagupan City" },
            "geometry": {
                "type": "Polygon",
                "coordinates": [[
                    [120.3283, 16.0505],
                    [120.3310, 16.0419],
                    [120.3350, 16.0350],
                    [120.3394, 16.0300],
                    [120.3450, 16.0258],
                    [120.3530, 16.0310],
                    [120.3578, 16.0350],
                    [120.3599, 16.0430],
                    [120.3550, 16.0505],
                    [120.3455, 16.0550],
                    [120.3350, 16.0552],
                    [120.3283, 16.0505]
                ]]
            }
        };

        L.geoJSON(dagupanBoundary, {
            style: {
                color: "#00BFFF",
                weight: 2,
                fillColor: "#00BFFF",
                fillOpacity: 0.4
            }
        }).addTo(map);
    });
</script>

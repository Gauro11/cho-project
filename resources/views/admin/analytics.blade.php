<style>
    /* General Modern Styling */
    body {
        background-color: #f8f9fc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1, h5, h6 {
        font-weight: 600;
    }

    .section-title {
        color: #000957;
        font-size: 1.4rem;
        border-left: 5px solid #000957;
        padding-left: 10px;
        margin-bottom: 20px;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        border: none;
        padding: 15px 20px;
    }

    .card-body {
        padding: 20px;
        background-color: #ffffff;
    }

    canvas {
        max-height: 300px;
    }

    /* Population label style */
    .population-label {
        font-size: 14px;
        color: #d9534f;
        font-weight: bold;
        text-align: center;
    }
</style>

<div class="container-fluid p-0">

<h1 style="color:#000957;" class="h3 mb-3 section-title"><strong>CITY HEALTH OFFICE ADMIN</strong><BR><strong>OVERVIEW</strong</BR></h1>
<div class="col-3 col-lg-3">
<div class="card"></div>
</div>

<h1 style="color:#000957;" class="h3 mb-3 section-title"><strong>IMMUNIZATION</strong></h1>
<div class="col-3 col-lg-3">
<div class="card"></div>
</div>

<div class="row">
    @foreach($immunizationData as $data)
        <div class="col-12 col-lg-6 mb-4">
            <div class="card">
                <div class="card-header" style="background-color: #000957; color: white;">
                    <h5 class="mb-0" style="color: white;">{{ $data->vaccine_name }} Vaccination</h5>
                    <h6 class="card-subtitle text-muted" style="color: white !important;">Date: {{ $data->date }}</h6>
                </div>
                <div class="card-body">
                    <canvas id="chart-{{ $data->id }}"></canvas>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        @foreach($immunizationData as $data)
            new Chart(document.getElementById("chart-{{ $data->id }}"), {
                type: "bar",
                data: {
                    labels: ["Male", "Female"],
                    datasets: [{
                        label: "Number Vaccinated",
                        backgroundColor: ["#4A90E2", "#FF4081"],
                        data: [{{ $data->male_vaccinated }}, {{ $data->female_vaccinated }}]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        @endforeach
    });
</script>

<h1 style="color:#000957;" class="h3 mb-3 section-title"><strong>MORBIDITY & MORTALITY</strong></h1>
<div class="col-3 col-lg-3">
<div class="card"></div>
</div>

<div class="row">
    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="mb-0" style="color: white !important;">Morbidity Cases</h5>
                <h6 class="card-subtitle text-muted" style="color: white !important;">Comparison of morbidity cases for male and female.</h6>
            </div>
            <div class="card-body">
                <canvas id="morbidityCasesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="mb-0" style="color: white !important;">Mortality Cases</h5>
                <h6 class="card-subtitle text-muted" style="color: white !important;">Comparison of mortality cases for male and female.</h6>
            </div>
            <div class="card-body">
                <canvas id="mortalityCasesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Chart(document.getElementById("morbidityCasesChart"), {
            type: "bar",
            data: {
                labels: {!! json_encode($morbidityCases->pluck('case_name')) !!},
                datasets: [{
                    label: "Male",
                    backgroundColor: "#4A90E2",
                    data: {!! json_encode($morbidityCases->pluck('male_count')) !!}
                }, {
                    label: "Female",
                    backgroundColor: "#FF4081",
                    data: {!! json_encode($morbidityCases->pluck('female_count')) !!}
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
        });

        new Chart(document.getElementById("mortalityCasesChart"), {
            type: "bar",
            data: {
                labels: {!! json_encode($mortalityCases->pluck('case_name')) !!},
                datasets: [{
                    label: "Male",
                    backgroundColor: "#1E88E5",
                    data: {!! json_encode($mortalityCases->pluck('male_count')) !!}
                }, {
                    label: "Female",
                    backgroundColor: "#D81B60",
                    data: {!! json_encode($mortalityCases->pluck('female_count')) !!}
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
        });
    });
</script>

<h1 style="color:#000957;" class="h3 mb-3 section-title"><strong>VITAL STATISTICS & POPULATION STATISTIC</strong></h1>
<div class="col-3 col-lg-3">
<div class="card"></div>
</div>

<div class="row">
    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="mb-0" style="color: white !important;">Population Growth</h5>
                <h6 class="card-subtitle text-muted" style="color: white !important;">Yearly total population statistics.</h6>
            </div>
            <div class="card-body">
                <canvas id="populationChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="mb-0" style="color: white !important;">Birth and Death Rates</h5>
                <h6 class="card-subtitle text-muted" style="color: white !important;">Live births vs. total deaths per year.</h6>
            </div>
            <div class="card-body">
                <canvas id="birthDeathChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Chart(document.getElementById("populationChart"), {
            type: "line",
            data: {
                labels: {!! json_encode($vitalStatisticsData->pluck('year')) !!},
                datasets: [{
                    label: "Total Population",
                    borderColor: "#4A90E2",
                    fill: false,
                    data: {!! json_encode($vitalStatisticsData->pluck('total_population')) !!}
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
        });

        new Chart(document.getElementById("birthDeathChart"), {
            type: "bar",
            data: {
                labels: {!! json_encode($vitalStatisticsData->pluck('year')) !!},
                datasets: [
                    { label: "Live Births", backgroundColor: "#2ECC71", data: {!! json_encode($vitalStatisticsData->pluck('total_live_births')) !!} },
                    { label: "Total Deaths", backgroundColor: "#E74C3C", data: {!! json_encode($vitalStatisticsData->pluck('total_deaths')) !!} }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
        });
    });
</script>

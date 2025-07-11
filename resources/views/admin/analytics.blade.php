<style>
    /* Style for population labels */
    .population-label {
        font-size: 14px;
        color: red;
        font-weight: bold;
        text-align: center;
    }
</style>

<div class="container-fluid p-0">

<h1 style="color:#000957;" class="h3 mb-3"><strong>CITY HEALTH OFFICE ADMIN</strong><BR><strong>OVERVIEW</strong</BR></h1>
<div class="col-3 col-lg-3">
<div class="card">
	
</div>
</div>




<div class="container-fluid p-0">

<h1 style="color:#000957;" class="h3 mb-3"><strong>IMMUNIZATION</strong><BR><strong></strong</BR></h1>
<div class="col-3 col-lg-3">
<div class="card">

</div>
</div>


<div class="row">
    @foreach($immunizationData as $data)
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header" style="background-color: #000957; color: white;">
                    <h5 class="card-title" style="color: white;">{{ $data->vaccine_name }} Vaccination</h5>
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


<style>
    /* Style for population labels */
    .population-label {
        font-size: 14px;
        color: red;
        font-weight: bold;
        text-align: center;
    }
</style>

<div class="container-fluid p-0">

<h1 style="color:#000957;" class="h3 mb-3"><strong>MORBIDITY & MORTALITY</strong><BR><strong></strong</BR></h1>
<div class="col-3 col-lg-3">
<div class="card">

</div>
</div>


<div class="row">
    <!-- Morbidity Cases Chart (Male & Female) -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="card-title"  style="color: white !important;">Morbidity Cases</h5>
                <h6 class="card-subtitle text-muted"  style="color: white !important;">Comparison of morbidity cases for male and female.</h6>
            </div>
            <div class="card-body">
                <canvas id="morbidityCasesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Mortality Cases Chart (Male & Female) -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="card-title"  style="color: white !important;">Mortality Cases</h5>
                <h6 class="card-subtitle text-muted"  style="color: white !important;">Comparison of mortality cases for male and female.</h6>
            </div>
            <div class="card-body">
                <canvas id="mortalityCasesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Morbidity Cases Chart (Male & Female)
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
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Mortality Cases Chart (Male & Female)
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
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>

<div class="container-fluid p-0">

<h1 style="color:#000957;" class="h3 mb-3"><strong>VITAL STATISTICS & POPULATION STATISTICS</strong><BR><strong></strong</BR></h1>
<div class="col-3 col-lg-3">
<div class="card">

</div>
</div>

<div class="row">
    <!-- Population Growth Chart -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="card-title"  style="color: white !important;">Population Growth</h5>
                <h6 class="card-subtitle text-muted"  style="color: white !important;">Yearly total population statistics.</h6>
            </div>
            <div class="card-body">
                <canvas id="populationChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Birth and Death Rates Chart -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="card-title"  style="color: white !important;">Birth and Death Rates</h5>
                <h6 class="card-subtitle text-muted"  style="color: white !important;">Live births vs. total deaths per year.</h6>
            </div>
            <div class="card-body">
                <canvas id="birthDeathChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Population Growth Chart
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

        // Birth and Death Rates Chart
        new Chart(document.getElementById("birthDeathChart"), {
            type: "bar",
            data: {
                labels: {!! json_encode($vitalStatisticsData->pluck('year')) !!},
                datasets: [
                    {
                        label: "Live Births",
                        backgroundColor: "#2ECC71",
                        data: {!! json_encode($vitalStatisticsData->pluck('total_live_births')) !!}
                    },
                    {
                        label: "Total Deaths",
                        backgroundColor: "#E74C3C",
                        data: {!! json_encode($vitalStatisticsData->pluck('total_deaths')) !!}
                    }
                ]
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
    });
</script>

<!-- 
<div class="row">
        
    <div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Dagupan City</h5>
            </div>
            <div class="card-body px-4">
            <div id="dagupanMap" style="height: 400px;"></div>
            </div>
        </div>
    </div>
    
</div> -->



</div














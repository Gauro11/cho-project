<div class="container-fluid p-0">

<h1 style="color:#000957;" class="h3 mb-3"><strong>VITAL STATISTICS & POPULATION STATISTICS</strong><BR><strong>OVERVIEW</strong</BR></h1>
<div class="col-3 col-lg-3">
<div class="card">

</div>
</div>

<div class="row">
    <!-- Population Growth Chart -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="card-title">Population Growth</h5>
                <h6 class="card-subtitle text-muted">Yearly total population statistics.</h6>
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
                <h5 class="card-title">Birth and Death Rates</h5>
                <h6 class="card-subtitle text-muted">Live births vs. total deaths per year.</h6>
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

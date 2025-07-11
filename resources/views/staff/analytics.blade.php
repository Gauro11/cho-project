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

<h1 style="color:#000957;" class="h3 mb-3"><strong>CITY HEALTH OFFICE STAFF</strong><BR><strong>OVERVIEW</strong</BR></h1>
<div class="col-3 col-lg-3">
<div class="card">
	
</div>
</div>


<div class="container-fluid p-0">

    <h1 style="color:#000957;" class="h3 mb-3"><strong>VITAL STATISTICS OVERVIEW</strong><BR><strong>
            </strong< /BR>
    </h1>
    <div class="col-3 col-lg-3">
        <div class="card">

        </div>
    </div>

    <div class="row">
        <!-- Population Growth Chart -->
        <div class="col-12 col-lg-6">
            <div class="card" style="background-color: white; color: black;">
                <div class="card-header" style="background-color: rgb(4, 150, 255); color: white;">
                    <h5 class="card-title" style="color: white !important;">Population Growth</h5>
                    <h6 class="card-subtitle text-muted" style="color: white !important;">Yearly total population
                        statistics.</h6>
                </div>
                <div class="card-body" style="background-color: white; color: black;">
                    <canvas id="populationChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Birth and Death Rates Chart -->
        <div class="col-12 col-lg-6">
            <div class="card" style="background-color: white; color: black;">
                <div class="card-header" style="background-color: rgb(4, 150, 255); color: white;">
                    <h5 class="card-title" style="color: white !important;">Birth and Death Rates</h5>
                    <h6 class="card-subtitle text-muted" style="color: white !important;">Live births vs. total deaths
                        per year.</h6>
                </div>
                <div class="card-body" style="background-color: white; color: black;">
                    <canvas id="birthDeathChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    // Function to sort data chronologically
    function sortByYear(data) {
        return data.sort((a, b) => a.year - b.year);
    }

    // Fetch and sort the vital statistics data
    let vitalStatisticsData = {!! json_encode($vitalStatisticsData) !!};
    let sortedData = sortByYear(vitalStatisticsData);

    // Population Growth Chart (Chronological Order)
    new Chart(document.getElementById("populationChart"), {
        type: "line",
        data: {
            labels: sortedData.map(item => item.year), // Sorted years
            datasets: [{
                label: "Total Population",
                borderColor: "#4A90E2",
                borderWidth: 2,
                fill: false,
                data: sortedData.map(item => item.total_population) // Sorted population
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

    // Birth and Death Rates Chart (Chronological Order)
    new Chart(document.getElementById("birthDeathChart"), {
        type: "line",
        data: {
            labels: sortedData.map(item => item.year), // Sorted years
            datasets: [
                {
                    label: "Live Births",
                    borderColor: "#2ECC71",
                    borderWidth: 3,
                    pointStyle: 'circle',
                    pointRadius: 5,
                    fill: false,
                    data: sortedData.map(item => item.total_live_births) // Sorted births
                },
                {
                    label: "Total Deaths",
                    borderColor: "#E74C3C",
                    borderWidth: 2,
                    borderDash: [5, 5], // Dashed line for deaths
                    pointStyle: 'rect',
                    pointRadius: 5,
                    fill: false,
                    data: sortedData.map(item => item.total_deaths) // Sorted deaths
                }
            ]
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
    <h1 style="color:#000957;" class="h3 mb-3"><strong>IMMUNIZATION</strong><BR><strong>OVERVIEW</strong></BR></h1>
    
 
            <div class="row">
                <div class="col-12">
            <div class="card" style="background-color: white; color: black;">
                        <div class="card-header" style="background-color:rgb(4, 150, 255); color: white;">
                        <h5 class="card-title" style="color: white;">Immunization Statistics</h5>
                    <h6 class="card-subtitle text-muted" style="color: white !important;">
                        Comparison of male and female vaccinations per vaccine type.
                        </h6>
                    </div>
                <div class="card-body" style="background-color: white; color: black;">
                    <canvas id="immunizationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
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

<h1 style="color:#000957;" class="h3 mb-3"><strong>MORBIDITY & MORTALITY OVERVIEW</strong><BR><strong></strong</BR></h1>
<div class="col-3 col-lg-3">
<div class="card">

</div>
</div>


<div class="row">
    <!-- Morbidity Cases Chart (Male & Female) -->
    <div class="col-12 col-lg-6">
        <div class="card" style="background-color: white; color: black;">
            <div class="card-header" style="background-color:rgb(4, 150, 255); color: white;">
                <h5 class="card-title"  style="color: white !important;">Morbidity Cases</h5>
                <h6 class="card-subtitle text-muted"  style="color: white !important;">Comparison of morbidity cases for male and female.</h6>
            </div>
            <div class="card-body" style="background-color: white; color: black;">
                <canvas id="morbidityCasesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Mortality Cases Chart (Male & Female) -->
    <div class="col-12 col-lg-6">
        <div class="card" style="background-color: white; color: black;">
            <div class="card-header" style="background-color: rgb(4, 150, 255); color: white;">
                <h5 class="card-title" style="color: white !important;">Mortality Cases</h5>
                <h6 class="card-subtitle text-muted" style="color: white !important;">Comparison of mortality cases for male
                    and female.</h6>
            </div>
            <div class="card-body" style="background-color: white; color: black;">
                <canvas id="mortalityCasesChart"></canvas>
            </div>
        </div>
    </div>

</div>

<style>
    /* Change background color to white */
    .chart-container {
        background-color: white !important;
        padding: 20px;
        border-radius: 10px;
        /* Optional: Add rounded corners */
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    function getChronologicalTopCases(data) {
        // Ensure the data is sorted by date (assuming a "date" field exists)
        data.sort((a, b) => new Date(a.date) - new Date(b.date));

        // Get the first 5 records in chronological order
        return data.slice(0, 5);
    }

    // Process Morbidity Data
    let morbidityData = {!! json_encode($morbidityCases) !!};
    let topMorbidityCases = getChronologicalTopCases(morbidityData);

    // Process Mortality Data
    let mortalityData = {!! json_encode($mortalityCases) !!};
    let topMortalityCases = getChronologicalTopCases(mortalityData);

    // Function to generate chart
    function createChart(chartId, caseData) {
        new Chart(document.getElementById(chartId), {
            type: "bar",
            data: {
                labels: caseData.map(c => c.case_name), // Top 5 case names in order
                datasets: [{
                    label: "Male",
                    backgroundColor: "yellow",
                    data: caseData.map(c => c.male_count) // Male cases
                }, {
                    label: "Female",
                    backgroundColor: "violet",
                    data: caseData.map(c => c.female_count) // Female cases
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: { color: "black" } // Adjust text color as needed
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: "black" }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: "black" }
                    }
                }
            }
        });
    }

    // Create charts with top 5 cases in chronological order
    createChart("morbidityCasesChart", topMorbidityCases);
    createChart("mortalityCasesChart", topMortalityCases);
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














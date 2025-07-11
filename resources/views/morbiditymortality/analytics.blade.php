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

<h1 style="color:#000957;" class="h3 mb-3"><strong>MORBIDITY & MORTALITY</strong><BR><strong>OVERVIEW</strong</BR></h1>
<div class="col-3 col-lg-3">
<div class="card">

</div>
</div>


<div class="row">
    <!-- Morbidity Cases Chart (Male & Female) -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="card-title">Morbidity Cases</h5>
                <h6 class="card-subtitle text-muted">Comparison of morbidity cases for male and female.</h6>
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
                <h5 class="card-title">Mortality Cases</h5>
                <h6 class="card-subtitle text-muted">Comparison of mortality cases for male and female.</h6>
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




</div




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

<h1 style="color:#000957;" class="h3 mb-3"><strong>IMMUNIZATION</strong><BR><strong>OVERVIEW</strong</BR></h1>
<div class="col-3 col-lg-3">
<div class="card">

</div>
</div>


<div class="row">
    <!-- Male Vaccination Chart -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="card-title">Male Vaccination</h5>
                <h6 class="card-subtitle text-muted">Number of males vaccinated per vaccine.</h6>
            </div>
            <div class="card-body">
                <canvas id="maleVaccinationChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Female Vaccination Chart -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header" style="background-color: #000957; color: white;">
                <h5 class="card-title">Female Vaccination</h5>
                <h6 class="card-subtitle text-muted">Number of females vaccinated per vaccine.</h6>
            </div>
            <div class="card-body">
                <canvas id="femaleVaccinationChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Male Vaccination Chart
        new Chart(document.getElementById("maleVaccinationChart"), {
            type: "bar",
            data: {
                labels: {!! json_encode($immunizationData->pluck('vaccine_name')) !!},
                datasets: [{
                    label: "Males Vaccinated",
                    backgroundColor: "#4A90E2",
                    data: {!! json_encode($immunizationData->pluck('male_vaccinated')) !!}
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

        // Female Vaccination Chart
        new Chart(document.getElementById("femaleVaccinationChart"), {
            type: "bar",
            data: {
                labels: {!! json_encode($immunizationData->pluck('vaccine_name')) !!},
                datasets: [{
                    label: "Females Vaccinated",
                    backgroundColor: "#FF4081",
                    data: {!! json_encode($immunizationData->pluck('female_vaccinated')) !!}
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
    });
</script>




<!DOCTYPE html>
<html lang="en">

<head>
    @include('staff.css')
    <style>
        .half-width {
            width: 48%;
        }

        .input-row {
            display: flex;
            justify-content: space-between;
            gap: 4%;
        }

        .save-button {
            margin-top: 20px;
        }

        /* Initially hide the form and table */
        #dataTable, #dataForm {
            display: none;
        }
        
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
        
        .prediction-line {
            border-color: #ff6384;
            border-width: 2px;
            border-style: dashed;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('staff.sidebar')

        <div class="main">
            @include('staff.header')
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle" >Trends Prediction</h1>
                        <br><br>
                        <div class="col-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Select Filters</h5>
                                </div>
                                <div class="card-body d-flex gap-2">
                                    <!-- Select Category Dropdown -->
                                    <select id="categorySelect" class="form-select">
                                        <option selected>Select Category</option>
                                        <option value="morbidity">Morbidity</option>
                                        <option value="mortality">Mortality</option>
                                        <!-- <option value="vital_statistics">Vital Statistics</option> -->
                                        <option value="population_statistics">Population Statistics</option>
                                        <!-- <option value="immunization">Immunization</option> -->
                                    </select>
                                    
                                    <!-- Sub-category for Morbidity/Mortality -->
                                    <select id="subCategorySelect" class="form-select" style="display: none;">
                                        <option value="">Select Case</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trend Line Chart -->
                    <div class="row">
                        <div class="col-xl-12 col-xxl-12">
                            <div class="card flex-fill w-100">
                                <div class="card-header" >
                                    <h5 class="card-title mb-0"  id="chartTitle">Trend Analysis</h5>
                                </div>
                                <div class="card-body py-3">
                                    <div class="chart-container">
                                        <canvas id="trendChart"></canvas>
                                    </div>
                                </div>
                                <div class="card-footer" id="predictionInfo">
                                    <!-- Prediction information will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            @include('staff.footer')
        </div>
    </div>
    @include('staff.js')

    <!-- Chart.js CDN with Regression Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-trendline"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@2.1.1"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const categorySelect = document.getElementById("categorySelect");
            const subCategorySelect = document.getElementById("subCategorySelect");
            const ctx = document.getElementById("trendChart").getContext("2d");
            const chartTitle = document.getElementById("chartTitle");
            const predictionInfo = document.getElementById("predictionInfo");
            
            // Define case types for morbidity/mortality
            const caseTypes = {
                morbidity: ['Animal Bite', 'Acute Respiratory Infection', 'Hypertension', 'Skin Diseases', 'Punctured/Lacerated Wound', 'Pneumonia', 'Diabetes Mellitus', 'Urinary Tract Infection', 'Gastritis/GERD', 'Systemic Viral Infection'
],
                mortality: ['Myocardial Infarction', 'Pneumonia', 'Cerebrovascular Disease', 'Kidney/Renal Disease', 'Cancer', 'Gastrointestinal Bleeding', 'Hypertension', 'Diabetes Mellitus', 'Traumatic Brain Injury', 'Liver Cirrhosis']
            };
            
            let chart;
            
            // Initialize the chart
            function initChart() {
                if (chart) {
                    chart.destroy();
                }
                
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [
                            {
                                label: 'Historical Data',
                                data: [],
                                borderColor: '#007bff',
                                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                                color: 'white',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Prediction',
                                data: [],
                                borderColor: '#ff6384',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                fill: false,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: 'white' // ✅ Change Y-axis values to white
                                },
                                title: {
                                    display: true,
                                    text: 'Count',
                                    color: 'white'
                                }
                            },
                            x: {
                                ticks: {
                                    color: 'white' // ✅ Change Y-axis values to white
                                },
                                title: {
                                    display: true,
                                    text: 'Time Period',
                                    color: 'white'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'white',  // Changes the font color of "Historical Data" and "Prediction"
                                    font: {
                                        size: 14, // Adjust font size if needed
                                        weight: 'bold' // Makes text bold if required
                                    }
                                }
                            },
                            annotation: {
                                annotations: {
                                    line1: {
                                        type: 'line',
                                        yMin: 0,
                                        yMax: 0,
                                        borderColor: 'rgb(255, 99, 132)',
                                        borderWidth: 2,
                                        borderDash: [5, 5],
                                        label: {
                                            content: 'Prediction Start',
                                            enabled: true,
                                            position: 'right',
                                            color: 'white'
                                        }
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += context.parsed.y;
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Initialize the chart on page load
            initChart();
            
            // Show/hide sub-category based on main category
            categorySelect.addEventListener("change", function () {
                const selectedCategory = categorySelect.value;
                
                if (selectedCategory === "morbidity" || selectedCategory === "mortality") {
                    subCategorySelect.style.display = 'block';
                    subCategorySelect.innerHTML = '<option value="">Select Case Type</option>';
                    
                    caseTypes[selectedCategory].forEach(caseType => {
                        subCategorySelect.innerHTML += `<option value="${caseType}">${caseType}</option>`;
                    });
                } else {
                    subCategorySelect.style.display = 'none';
                    loadChartData(selectedCategory);
                }
            });
            
            // Handle sub-category selection
            subCategorySelect.addEventListener("change", function () {
                const selectedCategory = categorySelect.value;
                const selectedSubCategory = subCategorySelect.value;
                
                if (selectedSubCategory) {
                    loadChartData(selectedCategory, selectedSubCategory);
                }
            });
            
            // Function to load chart data based on category
            async function loadChartData(category, subCategory = null) {
                try {
                    // Show loading state
                    chartTitle.textContent = `Loading ${category} data...`;
                    chart.data.labels = [];
                    chart.data.datasets[0].data = [];
                    chart.data.datasets[1].data = [];
                    chart.update();
                    
                    // Fetch data from server
                    let url = `/api/trend-data/${category}`;
                    if (subCategory) {
                        url += `?sub_category=${encodeURIComponent(subCategory)}`;
                    }
                    
                    const response = await fetch(url);
                    const data = await response.json();
                    
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to load data');
                    }
                    
                    // Update chart with historical data
                    chartTitle.textContent = `${subCategory || category} Trend Analysis`;
                    chart.data.labels = data.historical.labels;
                    chart.data.datasets[0].data = data.historical.values;
                    
                    // Update prediction data if available
                    if (data.prediction) {
                        const allLabels = [...data.historical.labels, ...data.prediction.labels];
                        const allValues = [...data.historical.values, ...data.prediction.values];
                        
                        chart.data.labels = allLabels;
                        chart.data.datasets[1].data = Array(data.historical.values.length).fill(null).concat(data.prediction.values);
                        
                        // Update annotation to mark prediction start
                        chart.options.plugins.annotation.annotations.line1.xMin = data.historical.labels.length - 1;
                        chart.options.plugins.annotation.annotations.line1.xMax = data.historical.labels.length - 1;
                    }
                    
                    chart.update();
                    
                    // Update prediction information
                    if (data.prediction) {
                        let predictionText = `<strong>Next 2 Months Prediction:</strong><br>`;
                        data.prediction.labels.forEach((month, index) => {
                            predictionText += `${month}: ${Math.round(data.prediction.values[index])} (${data.prediction.trend} trend)<br>`;
                        });
                        predictionInfo.innerHTML = predictionText;
                    } else {
                        predictionInfo.innerHTML = "No prediction available for this dataset.";
                    }
                    
                } catch (error) {
                    console.error("Error loading chart data:", error);
                    chartTitle.textContent = "Error Loading Data";
                    predictionInfo.innerHTML = `Error: ${error.message}`;
                }
            }
        });
    </script>

</body>

@if(session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif

</html>
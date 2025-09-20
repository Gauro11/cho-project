<!DOCTYPE html>
<html lang="en">

<head>
    @include('staff.css')
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

        body {
            font-family: 'Inter', sans-serif !important;
            color: var(--text-primary) !important;
            overflow-x: hidden !important;
            min-height: 100vh;
        }

        .wrapper {
            min-height: 100vh;
        }

        .section-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
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
            background: var(--card-bg) !important;
            backdrop-filter: blur(16px) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 20px !important;
            box-shadow: var(--shadow-glow) !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
            overflow: hidden !important;
            position: relative !important;
            margin-bottom: 2rem !important;
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.5) !important;
        }

        .card-header {
            background: var(--primary-gradient) !important;
            color: white !important;
            padding: 1.5rem !important;
            border: none !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .card-title {
            font-weight: 600 !important;
            font-size: 1.25rem !important;
            margin-bottom: 0.5rem !important;
            color: white !important;
            position: relative;
            z-index: 2;
        }

        .form-select,
        .form-control {
            background: rgba(128, 128, 128, 0.2) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(128, 128, 128, 0.3) !important;
            border-radius: 15px !important;
            color: var(--text-primary) !important;
            padding: 0.75rem 1rem !important;
            transition: all 0.3s ease !important;
            font-family: 'Inter', sans-serif !important;
        }

        .form-select option {
            background: #1a1a2e !important;
            color: var(--text-primary) !important;
        }

        .chart-container {
            height: 400px !important;
            background: rgba(255, 255, 255, 0.95) !important;
            border-radius: 15px !important;
            padding: 1rem !important;
            margin: 1rem !important;
            position: relative !important;
            overflow: hidden !important;
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

        @media (max-width: 768px) {
            .section-title {
                font-size: 1.5rem;
            }
            .col-6 {
                width: 100% !important;
            }
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
                        <h1 class="section-title pulse-animation">Trends Prediction</h1>

                        <div class="col-12 card-enter">
                            <div class="card glass-card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">🎯 Select Filters</h5>
                                </div>
                                <div class="card-body d-flex flex-wrap gap-2">
                                    <!-- Category -->
                                    <select id="categorySelect" class="form-select">
                                        <option selected>Select Category</option>
                                        <option value="morbidity">Morbidity</option>
                                        <option value="mortality">Mortality</option>
                                        <option value="population_statistics">Population Statistics</option>
                                    </select>

                                    <!-- Subcategory -->
                                    <select id="subCategorySelect" class="form-select" style="display:none;">
                                        <option value="">Select Case</option>
                                    </select>

                                    <!-- Filter type -->
                                    <select id="filterSelect" class="form-select">
                                        <option value="monthly" selected>Monthly</option>
                                        <option value="quarterly">Quarterly</option>
                                        <option value="yearly">Yearly</option>
                                        <option value="date">Specific Date</option>
                                    </select>

                                    <!-- Month -->
                                    <select id="monthSelect" class="form-select">
                                        <option value="">Month</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>

                                    <!-- Year -->
                                    <input type="number" id="yearInput" class="form-control" placeholder="Year" value="2025">

                                    <!-- Quarter -->
                                    <select id="quarterSelect" class="form-select">
                                        <option value="">Quarter</option>
                                        <option value="1">Q1</option>
                                        <option value="2">Q2</option>
                                        <option value="3">Q3</option>
                                        <option value="4">Q4</option>
                                    </select>

                                    <!-- Specific Date -->
                                    <input type="date" id="specificDate" class="form-control">

                                    <button class="btn btn-primary" onclick="applyFilter()">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart -->
                    <div class="row">
                        <div class="col-12 card-enter">
                            <div class="card glass-card flex-fill w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0" id="chartTitle">📊 Trend Analysis</h5>
                                </div>
                                <div class="card-body py-3">
                                    <div class="chart-container">
                                        <canvas id="trendChart"></canvas>
                                    </div>
                                </div>
                                <div class="card-footer" id="predictionInfo"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            @include('staff.footer')
        </div>
    </div>
    @include('staff.js')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@2.1.1"></script>

    <script>
        const ctx = document.getElementById("trendChart").getContext("2d");
        let chart;

        function initChart() {
            if (chart) chart.destroy();
            chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: [],
                    datasets: [
                        { label: "Historical Data", data: [], borderColor: "#007bff", backgroundColor: "rgba(0,123,255,0.2)", fill: true, tension: 0.4 },
                        { label: "Prediction", data: [], borderColor: "#ff6384", backgroundColor: "rgba(255,99,132,0.2)", borderDash: [5,5], fill: false, tension: 0.4 }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        annotation: {
                            annotations: {
                                line1: { type: "line", xMin: 0, xMax: 0, borderColor: "red", borderWidth: 2, borderDash: [5,5] }
                            }
                        }
                    }
                }
            });
        }
        initChart();

        async function loadChartData(params) {
            try {
                const url = `/public/api/trend-data/${params.category}?` + new URLSearchParams(params);
                const response = await fetch(url);
                const data = await response.json();
                if (!data.success) throw new Error("Failed to load");

                const histLabels = data.historical.labels;
                const histValues = data.historical.values;
                const predLabels = data.prediction?.labels || [];
                const predValues = data.prediction?.values || [];

                chart.data.labels = [...histLabels, ...predLabels];
                chart.data.datasets[0].data = histValues;
                chart.data.datasets[1].data = Array(histValues.length).fill(null).concat(predValues);

                chart.options.plugins.annotation.annotations.line1.xMin = histLabels.length - 1;
                chart.options.plugins.annotation.annotations.line1.xMax = histLabels.length - 1;

                chart.update();

                let info = "";
                if (data.prediction) {
                    data.prediction.labels.forEach((lbl, i) => {
                        info += `📅 ${lbl}: ${Math.round(data.prediction.values[i])}<br>`;
                    });
                } else {
                    info = "❌ No prediction available";
                }
                document.getElementById("predictionInfo").innerHTML = info;

            } catch (e) {
                console.error(e);
            }
        }

        function applyFilter() {
            const category = document.getElementById("categorySelect").value;
            const subCategory = document.getElementById("subCategorySelect").value;
            const filter = document.getElementById("filterSelect").value;
            const month = document.getElementById("monthSelect").value;
            const year = document.getElementById("yearInput").value;
            const quarter = document.getElementById("quarterSelect").value;
            const specificDate = document.getElementById("specificDate").value;

            if (!category) return alert("Select a category first");

            let params = { category, filter };
            if (subCategory) params.sub_category = subCategory;

            if (filter === "monthly" && month && year) { params.month = month; params.year = year; }
            if (filter === "quarterly" && quarter && year) { params.quarter = quarter; params.year = year; }
            if (filter === "yearly" && year) { params.year = year; }
            if (filter === "date" && specificDate) { params.date = specificDate; }

            loadChartData(params);
        }
    </script>
</body>
</html>

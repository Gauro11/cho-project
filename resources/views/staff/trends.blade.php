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

        .glass-card::before {
            display: none;
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.5) !important;
        }

        .card {
            background: var(--card-bg) !important;
            backdrop-filter: blur(16px) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 20px !important;
            box-shadow: var(--shadow-glow) !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
            overflow: hidden !important;
            position: relative !important;
        }

        .card:hover {
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

        .card-header::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .card-title {
            font-weight: 600 !important;
            font-size: 1.25rem !important;
            margin-bottom: 0.5rem !important;
            color: white !important;
            position: relative;
            z-index: 2;
        }

        .form-select, .form-control {
            background: rgba(128, 128, 128, 0.2) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(128, 128, 128, 0.3) !important;
            border-radius: 15px !important;
            color: var(--text-primary) !important;
            padding: 0.75rem 1rem !important;
            transition: all 0.3s ease !important;
            font-family: 'Inter', sans-serif !important;
        }

        .form-select:hover, .form-control:hover {
            background: rgba(128, 128, 128, 0.3) !important;
            border-color: rgba(128, 128, 128, 0.5) !important;
            transform: translateY(-1px);
        }

        .form-select:focus, .form-control:focus {
            background: rgba(128, 128, 128, 0.35) !important;
            border-color: #667eea !important;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
            color: var(--text-primary) !important;
            transform: translateY(-1px);
        }

        .form-select option {
            background: #1a1a2e !important;
            color: var(--text-primary) !important;
            padding: 0.5rem !important;
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

        .chart-container::before {
            display: none;
        }

        .card-footer {
            background: rgba(255, 255, 255, 0.05) !important;
            border-top: 1px solid var(--glass-border) !important;
            color: #333 !important;
            padding: 1.5rem !important;
            font-family: 'Inter', sans-serif !important;
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        .floating-circle:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-circle:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-circle:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        .card-enter {
            animation: slideInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .card-enter:nth-child(1) {
            animation-delay: 0.1s;
        }

        .card-enter:nth-child(2) {
            animation-delay: 0.2s;
        }

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
        
        .prediction-line {
            border-color: #ff6384;
            border-width: 2px;
            border-style: dashed;
        }

        /* Date filter styles */
        .date-filter-row {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .date-filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .date-filter-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        #monthPicker, #quarterPicker, #yearPicker {
            min-width: 150px;
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

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 1.5rem;
            }
            
            .col-6 {
                width: 100% !important;
            }

            .date-filter-row {
                flex-direction: column;
                align-items: stretch;
            }

            #monthPicker, #quarterPicker, #yearPicker {
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="wrapper">
        @include('staff.sidebar')

        <div class="main">
            @include('staff.header')
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="mb-3">
                        <h1 class="section-title pulse-animation">Trends Prediction</h1>
                        
                        <div class="col-12 col-lg-12 card-enter">
                            <div class="card glass-card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">🎯 Select Filters</h5>
                                </div>
                                <div class="card-body">
                                    <!-- First Row: Category and Sub-category -->
                                    <div class="d-flex gap-2 mb-3">
                                        <select id="categorySelect" class="form-select">
                                            <option selected>Select Category</option>
                                            <option value="morbidity">Morbidity</option>
                                            <option value="mortality">Mortality</option>
                                            <option value="population_statistics">Population Statistics</option>
                                        </select>
                                        
                                        <select id="subCategorySelect" class="form-select" style="display: none;">
                                            <option value="">Select Case</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Second Row: Date Filters -->
                                    <div class="date-filter-row">
                                        <div class="date-filter-group">
                                            <label class="date-filter-label">📅 Filter Type</label>
                                            <select id="dateFilterType" class="form-select">
                                                <option value="">All Data</option>
                                                <option value="specific">Specific Date</option>
                                                <option value="monthly">Monthly</option>
                                                <option value="quarterly">Quarterly</option>
                                                <option value="yearly">Yearly</option>
                                            </select>
                                        </div>
                                        
                                        <div class="date-filter-group" id="specificDateGroup" style="display: none;">
                                            <label class="date-filter-label">📆 Select Specific Date</label>
                                            <input type="date" id="specificDatePicker" class="form-control">
                                        </div>
                                        
                                        <div class="date-filter-group" id="monthFilterGroup" style="display: none;">
                                            <label class="date-filter-label">📆 Select Month</label>
                                            <input type="month" id="monthPicker" class="form-control">
                                        </div>
                                        
                                        <div class="date-filter-group" id="quarterFilterGroup" style="display: none;">
                                            <label class="date-filter-label">📊 Select Quarter</label>
                                            <select id="quarterPicker" class="form-select">
                                                <option value="">Select Quarter</option>
                                                <option value="Q1">Q1 (Jan-Mar)</option>
                                                <option value="Q2">Q2 (Apr-Jun)</option>
                                                <option value="Q3">Q3 (Jul-Sep)</option>
                                                <option value="Q4">Q4 (Oct-Dec)</option>
                                            </select>
                                        </div>
                                        
                                        <div class="date-filter-group" id="yearFilterGroup" style="display: none;">
                                            <label class="date-filter-label">🗓️ Select Year</label>
                                            <select id="yearPicker" class="form-select">
                                                <option value="">Select Year</option>
                                            </select>
                                        </div>
                                        
                                        <div class="date-filter-group" id="quarterYearGroup" style="display: none;">
                                            <label class="date-filter-label">🗓️ Select Year</label>
                                            <select id="quarterYearPicker" class="form-select">
                                                <option value="">Select Year</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trend Line Chart -->
                    <div class="row">
                        <div class="col-xl-12 col-xxl-12 card-enter">
                            <div class="card glass-card flex-fill w-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0" id="chartTitle">📊 Trend Analysis</h5>
                                </div>
                                <div class="card-body py-3">
                                    <div class="chart-container">
                                        <canvas id="trendChart"></canvas>
                                    </div>
                                </div>
                                <div class="card-footer" id="predictionInfo">
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

    <!-- Chart.js + Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-trendline"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@2.1.1"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById("trendChart").getContext("2d");
    const chartTitle = document.getElementById("chartTitle");
    const predictionInfo = document.getElementById("predictionInfo");

    let chart;
    let originalData = null;

    // Linear regression function
    function linearRegression(values) {
        const n = values.length;
        const x = values.map((_, i) => i + 1);
        const y = values;

        const sumX = x.reduce((a, b) => a + b, 0);
        const sumY = y.reduce((a, b) => a + b, 0);
        const sumXY = x.reduce((acc, xi, i) => acc + xi * y[i], 0);
        const sumXX = x.reduce((acc, xi) => acc + xi * xi, 0);

        const slope = (n * sumXY - sumX * sumY) / (n * sumXX - sumX * sumX);
        const intercept = (sumY - slope * sumX) / n;

        return { slope, intercept };
    }

    // Predict next months
    function predictNext(values, count = 2) {
        const { slope, intercept } = linearRegression(values);
        const predictions = [];
        for (let i = 1; i <= count; i++) {
            const nextX = values.length + i;
            predictions.push(intercept + slope * nextX);
        }
        return predictions;
    }

    // Initialize Chart
    function initChart() {
        if (chart) chart.destroy();
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Historical Data',
                        data: [],
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0,123,255,0.2)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Prediction',
                        data: [],
                        borderColor: '#ff6384',
                        backgroundColor: 'rgba(255,99,132,0.2)',
                        borderDash: [5, 5],
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { labels: { color: '#333', font: { size: 14, weight: 'bold' } } },
                    annotation: {
                        annotations: {
                            line1: {
                                type: 'line',
                                xMin: 0,
                                xMax: 0,
                                borderColor: 'red',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                label: { content: 'Prediction Start', enabled: true, position: 'right' }
                            }
                        }
                    }
                }
            }
        });
    }

    // Update chart with regression prediction
    function updateChart(data) {
        const labels = data.historical.labels;
        const values = data.historical.values;

        chart.data.labels = labels;
        chart.data.datasets[0].data = values;

        if (values.length > 2) {
            const predictions = predictNext(values, 2);
            chart.data.labels = [...labels, "Next 1", "Next 2"];
            chart.data.datasets[1].data = Array(values.length).fill(null).concat(predictions);

            predictionInfo.innerHTML = `
                <strong>🔮 Predictions:</strong><br>
                📅 Next 1: ${Math.round(predictions[0])}<br>
                📅 Next 2: ${Math.round(predictions[1])}
            `;
        } else {
            chart.data.datasets[1].data = [];
            predictionInfo.innerHTML = "❌ Not enough data for prediction.";
        }

        chart.options.plugins.annotation.annotations.line1.xMin = values.length - 1;
        chart.options.plugins.annotation.annotations.line1.xMax = values.length - 1;

        chart.update();
    }

    initChart();

    // Example: load dummy data
    originalData = {
        historical: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            values: [5, 9, 7, 10, 12, 15]
        }
    };
    updateChart(originalData);
});
</script>
</body>


@if(session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif

</html>
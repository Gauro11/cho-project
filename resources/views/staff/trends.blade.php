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

        .date-range-inputs {
            display: flex;
            gap: 0.5rem;
            align-items: center;
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

            .date-range-inputs {
                flex-direction: column;
            }
            
        }
        .date-filter-label {
    color: gray !important;
    font-weight: 500; /* optional para medyo makapal pa rin */
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
                                            <label class="date-filter-label">📆 Date Range</label>
                                            <div class="date-range-inputs">
                                                <input type="date" id="startDatePicker" class="form-control" placeholder="Start Date">
                                                <span style="color: var(--text-secondary);">to</span>
                                                <input type="date" id="endDatePicker" class="form-control" placeholder="End Date">
                                            </div>
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
document.addEventListener("DOMContentLoaded", function() {
    const categorySelect = document.getElementById("categorySelect");
    const subCategorySelect = document.getElementById("subCategorySelect");
    const dateFilterType = document.getElementById("dateFilterType");
    const specificDateGroup = document.getElementById("specificDateGroup");
    const monthFilterGroup = document.getElementById("monthFilterGroup");
    const quarterFilterGroup = document.getElementById("quarterFilterGroup");
    const yearFilterGroup = document.getElementById("yearFilterGroup");
    const quarterYearGroup = document.getElementById("quarterYearGroup");
    const startDatePicker = document.getElementById("startDatePicker");
    const endDatePicker = document.getElementById("endDatePicker");
    const monthPicker = document.getElementById("monthPicker");
    const quarterPicker = document.getElementById("quarterPicker");
    const yearPicker = document.getElementById("yearPicker");
    const quarterYearPicker = document.getElementById("quarterYearPicker");
    const ctx = document.getElementById("trendChart").getContext("2d");
    const chartTitle = document.getElementById("chartTitle");
    const predictionInfo = document.getElementById("predictionInfo");

    let chart;
    let originalData = null; // Store the original data for filtering

    // Initialize chart
    function initChart() {
        if (chart) chart.destroy();
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Historical Data',
                    data: [],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                },{
                    label: 'Prediction',
                    data: [],
                    borderColor: '#ff6384',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.4
                }]
            },
            options: {
                responsive:true,
                maintainAspectRatio:false,
                scales: {
                    y: { beginAtZero:true, ticks:{color:'#333'}, title:{display:true,text:'Count',color:'#333'} },
                    x: { ticks:{color:'#333'}, title:{display:true,text:'Time Period',color:'#333'} }
                },
                plugins: {
                    legend: { labels:{color:'#333', font:{size:14, weight:'bold'}} },
                    annotation: { annotations: {
                        line1: {
                            type:'line',
                            yMin:0,
                            yMax:0,
                            borderColor:'rgb(255, 99, 132)',
                            borderWidth:2,
                            borderDash:[5,5],
                            label:{content:'Prediction Start', enabled:true, position:'right', color:'#333'}
                        }
                    }},
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if(label) label += ': ';
                                if(context.parsed.y !== null) label += context.parsed.y;
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }

    // Populate years
    function populateYearDropdowns() {
        const currentYear = new Date().getFullYear();
        const startYear = 2020;
        [yearPicker, quarterYearPicker].forEach(picker=>{
            picker.innerHTML='<option value="">Select Year</option>';
            for(let y=currentYear;y>=startYear;y--){
                picker.innerHTML+=`<option value="${y}">${y}</option>`;
            }
        });
    }

    // --- Helper to parse YYYYMM format ---
    function parseYearMonth(label) {
        if(!label) return null;
        const str = label.toString();
        if(str.length===6){
            const year=parseInt(str.substring(0,4));
            const month=parseInt(str.substring(4,6))-1;
            return new Date(year, month, 1);
        } else if(str.length===4){
            return new Date(parseInt(str),0,1);
        }
        return null;
    }

    // --- Filter handlers ---
    dateFilterType.addEventListener("change",function(){
        const ft=dateFilterType.value;
        specificDateGroup.style.display='none';
        monthFilterGroup.style.display='none';
        quarterFilterGroup.style.display='none';
        yearFilterGroup.style.display='none';
        quarterYearGroup.style.display='none';

        if(ft==='specific') specificDateGroup.style.display='block';
        else if(ft==='monthly') monthFilterGroup.style.display='block';
        else if(ft==='quarterly'){ quarterFilterGroup.style.display='block'; quarterYearGroup.style.display='block'; }
        else if(ft==='yearly') yearFilterGroup.style.display='block';
        else if(originalData) applyDateFilter();
    });

    [startDatePicker,endDatePicker,monthPicker,quarterPicker,quarterYearPicker,yearPicker].forEach(el=>el.addEventListener('change',applyDateFilter));

    // --- Filtering functions ---
    function applyDateFilter(){
        if(!originalData) return;
        const ft=dateFilterType.value;
        let filtered={...originalData};

        if(ft==='specific'&&(startDatePicker.value||endDatePicker.value)) filtered=filterDataBySpecificDate(originalData);
        else if(ft==='monthly'&&monthPicker.value) filtered=filterDataByMonth(originalData,monthPicker.value);
        else if(ft==='quarterly'&&quarterPicker.value&&quarterYearPicker.value) filtered=filterDataByQuarter(originalData,quarterPicker.value,quarterYearPicker.value);
        else if(ft==='yearly'&&yearPicker.value) filtered=filterDataByYear(originalData,yearPicker.value);

        updateChart(filtered);
    }

    function filterDataBySpecificDate(data){
        const startDate=startDatePicker.value?new Date(startDatePicker.value):null;
        const endDate=endDatePicker.value?new Date(endDatePicker.value):null;
        if(!startDate&&!endDate) return data;

        const filteredLabels=[],filteredValues=[];
        data.historical.labels.forEach((label,i)=>{
            const date=parseYearMonth(label);
            if(date){
                let ok=true;
                if(startDate && date<startDate) ok=false;
                if(endDate && date>endDate) ok=false;
                if(ok){ filteredLabels.push(label); filteredValues.push(data.historical.values[i]); }
            }
        });

        let prediction=null;
        if(filteredValues.length>=2) prediction=generatePrediction(filteredLabels,filteredValues);

        return {...data, historical:{labels:filteredLabels,values:filteredValues}, prediction};
    }

    function filterDataByMonth(data,selectedMonth){
        const [y,m]=selectedMonth.split('-');
        const filteredLabels=[],filteredValues=[];
        data.historical.labels.forEach((label,i)=>{
            const date=parseYearMonth(label);
            if(date && date.getFullYear()==y && (date.getMonth()+1)==parseInt(m)){ 
                filteredLabels.push(label); filteredValues.push(data.historical.values[i]); 
            }
        });
        return {...data,historical:{labels:filteredLabels,values:filteredValues},prediction:null};
    }

    function filterDataByQuarter(data,q,y){
        const quarters={'Q1':[1,2,3],'Q2':[4,5,6],'Q3':[7,8,9],'Q4':[10,11,12]};
        const months=quarters[q];
        const filteredLabels=[],filteredValues=[];
        data.historical.labels.forEach((label,i)=>{
            const date=parseYearMonth(label);
            if(date && date.getFullYear()==y && months.includes(date.getMonth()+1)){
                filteredLabels.push(label); filteredValues.push(data.historical.values[i]);
            }
        });
        return {...data,historical:{labels:filteredLabels,values:filteredValues},prediction:null};
    }

    function filterDataByYear(data,y){
        const filteredLabels=[],filteredValues=[];
        data.historical.labels.forEach((label,i)=>{
            const date=parseYearMonth(label);
            if(date && date.getFullYear()==y){
                filteredLabels.push(label); filteredValues.push(data.historical.values[i]);
            }
        });
        return {...data,historical:{labels:filteredLabels,values:filteredValues},prediction:null};
    }

    function generatePrediction(labels,values){
        if(values.length<2) return null;
        const n=values.length;
        let sumX=0,sumY=0,sumXY=0,sumX2=0;
        for(let i=0;i<n;i++){sumX+=i; sumY+=values[i]; sumXY+=i*values[i]; sumX2+=i*i;}
        const slope=(n*sumXY-sumX*sumY)/(n*sumX2-sumX*sumX);
        const intercept=(sumY-slope*sumX)/n;

        const predictionLabels=[],predictionValues=[];
        const lastDate=parseYearMonth(labels[labels.length-1]);
        if(lastDate){
            for(let i=1;i<=2;i++){
                const fd=new Date(lastDate); fd.setMonth(fd.getMonth()+i);
                const fl=`${fd.getFullYear()}${String(fd.getMonth()+1).padStart(2,'0')}`;
                const fv=Math.max(0,slope*(n+i-1)+intercept);
                predictionLabels.push(fl); predictionValues.push(fv);
            }
        }

        return {labels:predictionLabels,values:predictionValues,formula:`y = ${slope.toFixed(2)}x + ${intercept.toFixed(2)}`};
    }

    // --- Update chart ---
    function updateChart(data){
        const formatLabel=l=>{
            const date=parseYearMonth(l);
            if(!date) return l;
            return date.toLocaleDateString('en-US',{month:'short',year:'numeric'});
        };
        const histLabels=data.historical.labels.map(formatLabel);
        chart.data.labels=histLabels;
        chart.data.datasets[0].data=data.historical.values;

        if(data.prediction){
            const predLabels=data.prediction.labels.map(formatLabel);
            chart.data.datasets[1].data=data.prediction.values;
            chart.data.datasets[1].label='Prediction';
            chart.data.labels=histLabels.concat(predLabels);
            predictionInfo.innerHTML=`<strong>Prediction Formula:</strong> ${data.prediction.formula}`;
        }else{
            chart.data.datasets[1].data=[];
            chart.data.datasets[1].label='Prediction';
            predictionInfo.innerHTML='';
        }
        chart.update();
    }

    // --- Initial setup ---
    initChart();
    populateYearDropdowns();

    // --- Simulate fetching data from server ---
    originalData = {
        historical: {
            labels: ['202510','202509','202508','202507','202506','202505'],
            values: [120,110,130,125,140,135]
        },
        prediction: null
    };
    updateChart(originalData);
});
</script>
</body>

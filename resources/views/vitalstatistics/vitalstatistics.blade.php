<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('staff.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --warning-gradient: linear-gradient(135deg, #feca57 0%, #ff9ff3 100%);
            --dark-bg: #0f0f23;
            --card-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.18);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --shadow-glow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            color: var(--text-primary);
        }



        .content {
            padding: 2rem;
        }

        /* Modern Page Title */
        .page-title {
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

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 10px;
        }

        /* Modern Glass Cards */
        .glass-card {
            background: var(--primary-gradient);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            box-shadow: var(--shadow-glow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
            margin-bottom: 2rem;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .glass-card:hover::before {
            left: 100%;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(31, 38, 135, 0.5);
        }

        /* Modern Card Body */
        .card-body {
            padding: 2rem;
            background: transparent;
        }

        /* Modern Buttons */
        .modern-btn {
            background: var(--primary-gradient);
            border: none;
            border-radius: 15px;
            padding: 12px 24px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .modern-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .modern-btn:hover::before {
            left: 100%;
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }

        .modern-btn.btn-success {
            background: var(--success-gradient);
            box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3);
        }

        .modern-btn.btn-success:hover {
            box-shadow: 0 8px 25px rgba(67, 233, 123, 0.5);
        }

        .modern-btn.btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .modern-btn.btn-primary {
            background: var(--primary-gradient);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        /* Modern Form Controls */
        .modern-form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 12px 20px;
            color: var(--text-primary);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        /* Generic focus style for all .modern-form-control */
        .modern-form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.2);
        }

        /* Text inputs, textareas get one color */
        input.modern-form-control:focus,
        textarea.modern-form-control:focus {
            color: var(--text-primary);
        }

        /* Select elements get their own color *//
        select.modern-form-control:focus {
            color: gray;
        }


        .modern-form-control::placeholder {
            color: var(--text-secondary);
        }

        /* Modern Input Group */
        .modern-input-group {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
        }

        .modern-input-group .input-group-text {
            background: transparent;
            border: none;
            color: var(--text-primary);
        }

        /* Modern Modal */
        .modern-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .modern-modal-content {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 25px;
            box-shadow: var(--shadow-glow);
            padding: 2rem;
            width: 90%;
            max-width: 500px;
            position: relative;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modern-modal-content h2 {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .modern-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
            color: var(--text-primary);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .modern-close:hover {
            background: var(--secondary-gradient);
            transform: rotate(90deg);
        }

        /* Modern Form Labels */
        .modern-form-label {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Modern Modal Footer */
        .modern-modal-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            gap: 1rem;
        }

        /* Highlight Search Results */
        .highlight {
            background: linear-gradient(135deg, #feca57 0%, #ff9ff3 100%);
            color: #000;
            font-weight: bold;
            padding: 2px 4px;
            border-radius: 4px;
        }

        /* Modern Pagination */
        .custom-pagination {
            display: flex;
            list-style: none;
            padding: 0;
            border-radius: 15px;
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            padding: 8px 12px;
            justify-content: center;
        }

        .custom-pagination .page-item {
            margin: 0 5px;
        }

        .custom-pagination .page-link {
            color: var(--text-primary);
            padding: 8px 12px;
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            transition: 0.3s;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.05);
        }

        .custom-pagination .page-item.active .page-link,
        .custom-pagination .page-link:hover {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }

        .custom-pagination .disabled .page-link {
            color: var(--text-secondary);
            pointer-events: none;
            border: 1px solid var(--text-secondary);
        }

        /* Animations */
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

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Modern Table Styles */
        .modern-table {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid var(--glass-border);
        }

        .modern-table th {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1rem;
            font-weight: 600;
        }

        .modern-table td {
            background: rgba(255, 255, 255, 0.02);
            border: none;
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem;
            color: var(--text-primary);
        }

        .modern-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        /* Action Buttons in Table */
        .action-btn {
            padding: 6px 12px;
            border-radius: 8px;
            border: none;
            margin: 0 2px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.8rem;
        }

        .action-btn.edit {
            background: var(--warning-gradient);
            color: white;
        }

        .action-btn.delete {
            background: var(--secondary-gradient);
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Separator Styles */
        .separator {
            color: var(--text-secondary);
            font-weight: bold;
            margin: 0 10px;
        }

        /* File Upload Styling */
        .file-upload-area {
            border: 2px dashed var(--glass-border);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .file-upload-area:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .file-upload-area.dragover {
            border-color: #43e97b;
            background: rgba(67, 233, 123, 0.1);
            transform: scale(1.02);
        }

        .file-upload-icon {
            font-size: 3rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .file-upload-text {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .file-info {
            background: rgba(67, 233, 123, 0.1);
            border: 1px solid rgba(67, 233, 123, 0.3);
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
            display: none;
        }

        .file-info.show {
            display: block;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.8rem;
            }

            .modern-modal-content {
                width: 95%;
                padding: 1.5rem;
            }

            .content {
                padding: 1rem;
            }
        }

        @media print {

            .no-print,
            .pagination {
                display: none !important;
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

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h1 class="page-title">Vital Statistics Records</h1>
                        <div class="d-flex gap-2" style="width: 100%; max-width: 400px;">
                        </div>
                    </div>

                    <br><br>

                    <div class="col-12 col-lg-12 fade-in-up">
                        <div class="glass-card">
                            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <!-- Settings Icon (White Color) -->
                                    <button class="modern-btn btn-success btn-sm" id="openModal">
                                        ➕ Add New Record
                                    </button>
                                    <!-- <i id="openModal" data-feather="plus" style="color: white; cursor: pointer;"></i> -->

                                    <!-- Vertical Bar Separator -->
                                    <span class="separator">|</span>
                                    <div class="modern-input-group input-group" style="width: 300px;">
                                        <span class="input-group-text bg-transparent"><i
                                                data-feather="search"></i></span>
                                        <input type="text" id="searchInput" name="search"
                                            class="form-control modern-form-control" placeholder="Search records..."
                                            style="border-left: none;">
                                    </div>

                                    <span class="separator">|</span>

                                    <!-- Search Field with Icon (Next to the Separator) -->

                                </div>

                                <!-- Pagination + Download Icon on the Right -->
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <!-- Import Button -->
                                    <button class="modern-btn btn-secondary btn-sm" id="openImportModal">
                                        <i data-feather="upload"></i> Import
                                    </button>

                                    <button id="printTable" class="modern-btn btn-primary btn-sm">
                                        <i data-feather="printer"></i> Print
                                    </button>

                                    <!-- Download Icon -->
                                    <a href="{{ route('exportVitalStatistics') }}"
                                        class="modern-btn btn-success btn-sm">
                                        <i data-feather="download"></i> Download
                                    </a>



                                    <!-- <span style="color: white; font-weight: bold;">|</span>

                                    <i data-feather="maximize-2" style="color: white;"></i> -->

                                </div>
                            </div>
                        </div>
                    </div>

                    @include('vitalstatistics.table')

                    <!-- Initialize Feather Icons -->
                    <script>
                        feather.replace();
                    </script>



                    <!-- Import Modal -->
                    <div id="importModal" class="modern-modal modal">
                        <div class="modern-modal-content modal-content">
                            <span class="modern-close close" id="closeImportModal">&times;</span>
                            <h2>📤 Import Vital Statistics Records</h2>
                            <form action="{{ route('vital_statistics.import') }}" method="POST"
                                enctype="multipart/form-data" id="importForm">
                                @csrf
                                <div class="file-upload-area" id="fileUploadArea">
                                    <div class="file-upload-icon">📁</div>
                                    <div class="file-upload-text">
                                        <strong>Click to select file</strong> or drag and drop your Excel/CSV file here
                                    </div>
                                    <input type="file" name="file" id="fileInput"
                                        class="modern-form-control form-control" accept=".xlsx,.xls,.csv" required
                                        style="display: none;">
                                    <button type="button" class="modern-btn btn-secondary btn-sm"
                                        onclick="document.getElementById('fileInput').click()">
                                        📂 Choose File
                                    </button>
                                </div>

                                <div class="file-info" id="fileInfo">
                                    <strong>Selected File:</strong>
                                    <div id="fileName"></div>
                                    <div id="fileSize"></div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted">
                                        <strong>Supported formats:</strong> Excel (.xlsx, .xls) and CSV (.csv)<br>
                                        <strong>Required columns:</strong> Month & Year, Total Population, Total Live
                                        Births, Total Deaths, Infant Deaths, Maternal Deaths
                                    </small>
                                </div>

                                <div class="modern-modal-footer modal-footer">
                                    <button type="button" class="modern-btn btn-secondary" id="cancelImportModal">❌
                                        Cancel</button>
                                    <button type="submit" class="modern-btn btn-success" id="uploadBtn" disabled>📤
                                        Upload File</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modern Modal Structure -->
                    <div id="customModal" class="modern-modal modal">
                        <div class="modern-modal-content modal-content">
                            <span class="modern-close close">&times;</span>
                            <h2>📈 Add Vital Statistics Records</h2>
                            <form action="{{ route('vital_statistics.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="month_year" class="modern-form-label form-label">📅 Month & Year</label>
                                    <select class="modern-form-control form-control" id="month_year" name="month_year"
                                        required>
                                        @for ($y = date('Y'); $y >= 1900; $y--)
                                            @php
                                                $startMonth = $y == date('Y') ? date('n') : 12;
                                            @endphp
                                            @for ($m = $startMonth; $m >= 1; $m--)
                                                <option
                                                    value="{{ $y }}-{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }} {{ $y }}
                                                </option>
                                            @endfor
                                        @endfor
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="total_population" class="modern-form-label form-label">👥 Total
                                        Population</label>
                                    <input type="number" class="modern-form-control form-control"
                                        id="total_population" name="total_population" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="total_live_births" class="modern-form-label form-label">👶 Total Live
                                        Births</label>
                                    <input type="number" class="modern-form-control form-control"
                                        id="total_live_births" name="total_live_births" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="total_deaths" class="modern-form-label form-label">⚰️ Total
                                        Deaths</label>
                                    <input type="number" class="modern-form-control form-control" id="total_deaths"
                                        name="total_deaths" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="infant_deaths" class="modern-form-label form-label">👼 Infant
                                        Deaths</label>
                                    <input type="number" class="modern-form-control form-control" id="infant_deaths"
                                        name="infant_deaths" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="maternal_deaths" class="modern-form-label form-label">🤱 Maternal
                                        Deaths</label>
                                    <input type="number" class="modern-form-control form-control"
                                        id="maternal_deaths" name="maternal_deaths" required min="0">
                                </div>

                                <div class="modern-modal-footer modal-footer">
                                    <button type="submit" class="modern-btn btn-primary">✅ Add Vital Statistics
                                        Records</button>
                                </div>
                            </form>


                        </div>
                    </div>
                    <script>
                        const totalDeathsInput = document.getElementById("total_deaths");
                        const infantDeathsInput = document.getElementById("infant_deaths");
                        const maternalDeathsInput = document.getElementById("maternal_deaths");

                        function enforceDependency() {
                            let totalDeaths = parseInt(totalDeathsInput.value) || 0;
                            let infantDeaths = parseInt(infantDeathsInput.value) || 0;
                            let maternalDeaths = parseInt(maternalDeathsInput.value) || 0;
                            let maxAllowed = totalDeaths;

                            // Reset error states
                            infantDeathsInput.classList.remove('input-dependency-error');
                            maternalDeathsInput.classList.remove('input-dependency-error');

                            // Ensure infant and maternal deaths do not exceed total deaths
                            if (infantDeaths + maternalDeaths > maxAllowed) {
                                infantDeathsInput.classList.add('input-dependency-error');
                                maternalDeathsInput.classList.add('input-dependency-error');

                                // Create modern alert
                                showModernAlert("⚠️ Validation Error", "The sum of Infant and Maternal Deaths cannot exceed Total Deaths.");
                                infantDeathsInput.value = Math.max(0, maxAllowed - maternalDeaths);
                            }
                        }

                        // Modern alert function
                        function showModernAlert(title, message) {
                            // Create alert overlay
                            const alertOverlay = document.createElement('div');
                            alertOverlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 10000;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-out;
        `;

                            // Create alert box
                            const alertBox = document.createElement('div');
                            alertBox.style.cssText = `
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 25px;
            box-shadow: var(--shadow-glow);
            padding: 2rem;
            max-width: 400px;
            text-align: center;
            color: var(--text-primary);
            animation: modalSlideIn 0.3s ease-out;
        `;

                            alertBox.innerHTML = `
            <h3 style="background: var(--secondary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 1rem;">${title}</h3>
            <p style="margin-bottom: 2rem; color: var(--text-secondary);">${message}</p>
            <button onclick="this.closest('.alert-overlay').remove()" style="background: var(--primary-gradient); border: none; border-radius: 15px; padding: 10px 20px; color: white; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">OK</button>
        `;

                            alertOverlay.className = 'alert-overlay';
                            alertOverlay.appendChild(alertBox);
                            document.body.appendChild(alertOverlay);

                            // Auto remove after 5 seconds
                            setTimeout(() => {
                                if (document.body.contains(alertOverlay)) {
                                    alertOverlay.remove();
                                }
                            }, 5000);
                        }

                        totalDeathsInput.addEventListener("input", function() {
                            let totalDeaths = parseInt(this.value) || 0;
                            infantDeathsInput.max = totalDeaths;
                            maternalDeathsInput.max = totalDeaths;
                            enforceDependency();
                        });

                        infantDeathsInput.addEventListener("input", enforceDependency);
                        maternalDeathsInput.addEventListener("input", enforceDependency);

                        const maleCountInput = document.getElementById('male_count');
                        const femaleCountInput = document.getElementById('female_count');
                        const totalInput = document.getElementById('total');

                        function calculate() {
                            if (maleCountInput && femaleCountInput && totalInput) {
                                const maleCount = parseInt(maleCountInput.value) || 0;
                                const femaleCount = parseInt(femaleCountInput.value) || 0;
                                const total = maleCount + femaleCount;
                                totalInput.value = total;

                                // Percentage calculation based on male count relative to total
                                const percentage = total > 0 ? ((maleCount / total) * 100).toFixed(2) : 0;
                            }
                        }

                        if (maleCountInput) maleCountInput.addEventListener('input', calculate);
                        if (femaleCountInput) femaleCountInput.addEventListener('input', calculate);
                    </script>



                    <div id="editModal" class="modern-modal modal" style="display: none;">
                        <div class="modern-modal-content modal-content">
                            <span id="closeEditModalTop" class="modern-close close">&times;</span>
                            <h2>✏️ Edit Data</h2>
                            <form id="updateForm" action="{{ route('vital_statistics.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit_id" name="id">

                                <div class="mb-3">
                                    <label for="month_year" class="modern-form-label form-label">📅 Month &
                                        Year</label>
                                    <select class="modern-form-control form-control" id="edit_year" name="year"
                                        required>
                                        @for ($y = date('Y'); $y >= 1900; $y--)
                                            @php
                                                $startMonth = $y == date('Y') ? date('n') : 12;
                                            @endphp
                                            @for ($m = $startMonth; $m >= 1; $m--)
                                                <option
                                                    value="{{ $y }}-{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }} {{ $y }}
                                                </option>
                                            @endfor
                                        @endfor
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="edit_population" class="modern-form-label form-label">👥
                                        Population</label>
                                    <input type="number" class="modern-form-control form-control"
                                        id="edit_population" name="total_population" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="edit_births" class="modern-form-label form-label">👶 Total Live
                                        Births</label>
                                    <input type="number" class="modern-form-control form-control" id="edit_births"
                                        name="total_live_births" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="edit_deaths" class="modern-form-label form-label">⚰️ Total
                                        Deaths</label>
                                    <input type="number" class="modern-form-control form-control" id="edit_deaths"
                                        name="total_deaths" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="edit_infant" class="modern-form-label form-label">👼 Infant
                                        Deaths</label>
                                    <input type="number" class="modern-form-control form-control" id="edit_infant"
                                        name="infant_deaths" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="edit_maternal" class="modern-form-label form-label">🤱 Maternal
                                        Deaths</label>
                                    <input type="number" class="modern-form-control form-control" id="edit_maternal"
                                        name="maternal_deaths" required min="0">
                                </div>

                                <div class="modern-modal-footer modal-footer">
                                    <button type="button" id="cancelEditModal" class="modern-btn btn-secondary">❌
                                        Cancel</button>
                                    <button type="submit" class="modern-btn btn-primary">💾 Update Vital Statistics
                                        Records</button>
                                </div>
                            </form>
                        </div>
                    </div>



                    <!-- Initialize Feather Icons -->
                    <script>
                        feather.replace();
                    </script>


                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            setTimeout(() => {
                                var modal = document.getElementById("customModal");
                                var openModalBtn = document.getElementById("openModal");
                                var closeModalBtn = document.querySelector("#customModal .close");

                                if (!modal || !openModalBtn) {
                                    console.error("Modal or button not found!");
                                    return;
                                }

                                openModalBtn.addEventListener("click", function() {
                                    modal.style.display = "flex";
                                });

                                closeModalBtn.addEventListener("click", function() {
                                    modal.style.display = "none";
                                });

                                window.addEventListener("click", function(event) {
                                    if (event.target === modal) {
                                        modal.style.display = "none";
                                    }
                                });
                            }, 100); // Delay to ensure icons are loaded
                        });
                    </script>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const modal = document.getElementById('editModal');
                            const cancelBtn = document.getElementById('cancelEditModal');
                            const topCloseBtn = document.getElementById('closeEditModalTop'); // the X
                            const updateForm = document.getElementById('updateForm');

                            // Form submit (AJAX)
                            updateForm.addEventListener('submit', function(e) {
                                e.preventDefault();
                                let formData = new FormData(this);
                                formData.append('_method', 'PUT');
                                fetch(`/vital-statistics/update`, {
                                        method: "POST",
                                        headers: {
                                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                            "X-Requested-With": "XMLHttpRequest",
                                        },
                                        body: formData,
                                    })
                                    .then(r => r.json())
                                    .then(data => {
                                        if (data.success) {
                                            showModernAlert("✅ Success", "Record updated successfully!");
                                            setTimeout(() => location.reload(), 1400);
                                        } else {
                                            showModernAlert("❌ Error", data.message || "Failed to update.");
                                        }
                                    })
                                    .catch(err => {
                                        console.error(err);
                                        showModernAlert("❌ Error", "An error occurred while updating.");
                                    });
                            });

                            // Close handlers
                            function closeModal() {
                                modal.style.display = 'none';
                            }

                            cancelBtn && cancelBtn.addEventListener('click', closeModal);
                            topCloseBtn && topCloseBtn.addEventListener('click', closeModal);

                            // close on click outside content
                            window.addEventListener('click', function(ev) {
                                if (ev.target === modal) closeModal();
                            });

                            // close on ESC
                            document.addEventListener('keydown', function(ev) {
                                if (ev.key === 'Escape' || ev.key === 'Esc') {
                                    // ensure modal visible before closing
                                    if (getComputedStyle(modal).display !== 'none') closeModal();
                                }
                            });
                        });
                    </script>




                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.querySelectorAll(".delete-button").forEach(button => {
                                button.addEventListener("click", function() {
                                    const dataId = this.dataset.id;
                                    const tableRow = this.closest("tr"); // Get the row to delete later

                                    // Modern confirmation overlay
                                    const confirmOverlay = document.createElement('div');
                                    confirmOverlay.classList.add("confirm-overlay"); // Add class for easy removal
                                    confirmOverlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(5px);
                z-index: 10000;
                display: flex;
                justify-content: center;
                align-items: center;
                animation: fadeIn 0.3s ease-out;
            `;

                                    // Modal box
                                    const confirmBox = document.createElement('div');
                                    confirmBox.style.cssText = `
                background: #1e1e2f;
                border-radius: 20px;
                padding: 2rem;
                max-width: 400px;
                width: 100%;
                text-align: center;
                color: #fff;
                box-shadow: 0 8px 25px rgba(0,0,0,0.3);
                animation: modalSlideIn 0.3s ease-out;
            `;

                                    confirmBox.innerHTML = `
                <h3 style="margin-bottom: 1rem; font-size: 1.4rem; background: linear-gradient(90deg, #ff4d4d, #ff8080); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">🗑️ Confirm Delete</h3>
                <p style="margin-bottom: 2rem; font-size: 1rem; color: #ccc;">Are you sure you want to delete this vital statistics record? This action cannot be undone.</p>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <button id="cancelDelete" style="background: linear-gradient(90deg, #6c757d, #8a94a6); border: none; border-radius: 12px; padding: 10px 20px; color: white; font-weight: 600; cursor: pointer;">❌ Cancel</button>
                    <button id="confirmDelete" style="background: linear-gradient(90deg, #ff4d4d, #ff8080); border: none; border-radius: 12px; padding: 10px 20px; color: white; font-weight: 600; cursor: pointer;">🗑️ Delete</button>
                </div>
            `;

                                    confirmOverlay.appendChild(confirmBox);
                                    document.body.appendChild(confirmOverlay);

                                    // Cancel action
                                    confirmBox.querySelector("#cancelDelete").addEventListener("click", () => {
                                        confirmOverlay.remove();
                                    });

                                    // Confirm action
                                    confirmBox.querySelector("#confirmDelete").addEventListener("click", () => {
                                        confirmDelete(dataId, tableRow);
                                    });
                                });
                            });

                            // Confirm delete function without page reload
                            window.confirmDelete = function(dataId, tableRow) {
                                fetch(`/vitalstatistics/delete/${dataId}`, {
                                        method: "DELETE",
                                        headers: {
                                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                            "Content-Type": "application/json"
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        document.querySelector('.confirm-overlay')?.remove();
                                        if (data.success) {
                                            // Fade out before removing
                                            tableRow.style.transition = "opacity 0.5s";
                                            tableRow.style.opacity = "0";
                                            setTimeout(() => tableRow.remove(), 500);

                                            showModernAlert("✅ Success", "Data deleted successfully!");
                                        } else {
                                            showModernAlert("❌ Error", "Failed to delete data.");
                                        }
                                    })
                                    .catch(error => {
                                        document.querySelector('.confirm-overlay')?.remove();
                                        console.error("Error:", error);
                                        showModernAlert("❌ Error", "Something went wrong.");
                                    });
                            };

                            // Modern toast alert
                            window.showModernAlert = function(title, message) {
                                const alertBox = document.createElement('div');
                                alertBox.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1e1e2f;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 10001;
            animation: fadeIn 0.3s ease-out;
        `;
                                alertBox.innerHTML = `<strong>${title}</strong><br><span style="color:#ccc;">${message}</span>`;
                                document.body.appendChild(alertBox);
                                setTimeout(() => {
                                    alertBox.style.opacity = "0";
                                    setTimeout(() => alertBox.remove(), 500);
                                }, 2000);
                            };
                        });
                    </script>


                    <style>
                        @keyframes fadeIn {
                            from {
                                opacity: 0;
                            }

                            to {
                                opacity: 1;
                            }
                        }

                        @keyframes modalSlideIn {
                            from {
                                transform: translateY(-20px);
                                opacity: 0;
                            }

                            to {
                                transform: translateY(0);
                                opacity: 1;
                            }
                        }
                    </style>


                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        document.getElementById("searchInput").addEventListener("input", function() {
                            let searchValue = this.value.toLowerCase();
                            let rows = document.querySelectorAll("#dataTable tbody tr");

                            rows.forEach(row => {
                                let cells = row.querySelectorAll("td");
                                let found = false;

                                // Check all cells in the row for matching text
                                cells.forEach(cell => {
                                    let text = cell.innerText.toLowerCase();
                                    if (text.includes(searchValue)) {
                                        found = true;
                                    }
                                });

                                // Show or hide row based on match
                                if (searchValue === "" || found) {
                                    row.style.display = "";

                                    // Apply highlighting to matching text
                                    if (searchValue !== "") {
                                        cells.forEach(cell => {
                                            let text = cell.innerText;
                                            let regex = new RegExp(`(${searchValue})`, "gi");
                                            if (text.toLowerCase().includes(searchValue)) {
                                                cell.innerHTML = text.replace(regex,
                                                    `<span class="highlight">$1</span>`);
                                            }
                                        });
                                    } else {
                                        // Remove highlighting when search is cleared
                                        cells.forEach(cell => {
                                            cell.innerHTML = cell.innerText;
                                        });
                                    }
                                } else {
                                    row.style.display = "none";
                                }
                            });
                        });
                    </script>

                    <!-- <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.querySelectorAll(".delete-button").forEach(button => {
                                button.addEventListener("click", function() {
                                    let dataId = this.dataset.id;

                                    if (confirm("Are you sure you want to delete this data?")) {
                                        fetch(`/data/${dataId}`, {
                                            method: "DELETE",
                                            headers: {
                                                "X-CSRF-TOKEN": document.querySelector(
                                                    'meta[name="csrf-token"]').content
                                            }
                                        }).then(response => {
                                            if (response.ok) {
                                                showModernAlert("✅ Success", "Data deleted successfully!");
                                                setTimeout(() => location.reload(), 1500);
                                            } else {
                                                showModernAlert("❌ Error", "Error deleting data.");
                                            }
                                        });
                                    }
                                });
                            });
                        });
                    </script> -->

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            // Add New Record Modal
                            setTimeout(() => {
                                var modal = document.getElementById("customModal");
                                var openModalBtn = document.getElementById("openModal");
                                var closeModalBtn = document.querySelector("#customModal .close");

                                if (!modal || !openModalBtn) {
                                    console.error("Modal or button not found!");
                                    return;
                                }

                                openModalBtn.addEventListener("click", function() {
                                    modal.style.display = "flex";
                                });

                                closeModalBtn.addEventListener("click", function() {
                                    modal.style.display = "none";
                                });

                                window.addEventListener("click", function(event) {
                                    if (event.target === modal) {
                                        modal.style.display = "none";
                                    }
                                });
                            }, 100);

                            // Import Modal
                            var importModal = document.getElementById("importModal");
                            var openImportModalBtn = document.getElementById("openImportModal");
                            var closeImportModalBtn = document.getElementById("closeImportModal");
                            var cancelImportModalBtn = document.getElementById("cancelImportModal");
                            var fileInput = document.getElementById("fileInput");
                            var fileUploadArea = document.getElementById("fileUploadArea");
                            var fileInfo = document.getElementById("fileInfo");
                            var fileName = document.getElementById("fileName");
                            var fileSize = document.getElementById("fileSize");
                            var uploadBtn = document.getElementById("uploadBtn");

                            // Allowed file types
                            const allowedExtensions = ['xlsx', 'xls', 'csv'];

                            // Open Import Modal
                            openImportModalBtn.addEventListener("click", function() {
                                importModal.style.display = "flex";
                            });

                            // Close Import Modal
                            closeImportModalBtn.addEventListener("click", closeImportModal);
                            cancelImportModalBtn.addEventListener("click", closeImportModal);

                            function closeImportModal() {
                                importModal.style.display = "none";
                                resetFileUpload();
                            }

                            // Close modal when clicking outside
                            window.addEventListener("click", function(event) {
                                if (event.target === importModal) {
                                    closeImportModal();
                                }
                            });

                            // File upload functionality
                            fileInput.addEventListener("change", function() {
                                validateAndHandleFile(this.files[0]);
                            });

                            // Drag and drop functionality
                            fileUploadArea.addEventListener("dragover", function(e) {
                                e.preventDefault();
                                this.classList.add("dragover");
                            });

                            fileUploadArea.addEventListener("dragleave", function(e) {
                                this.classList.remove("dragover");
                            });

                            fileUploadArea.addEventListener("drop", function(e) {
                                e.preventDefault();
                                this.classList.remove("dragover");
                                var files = e.dataTransfer.files;
                                if (files.length > 0) {
                                    fileInput.files = files;
                                    validateAndHandleFile(files[0]);
                                }
                            });

                            // Validate file extension before showing info
                            function validateAndHandleFile(file) {
                                if (!file) {
                                    resetFileUpload();
                                    return;
                                }

                                const ext = file.name.split('.').pop().toLowerCase();
                                if (!allowedExtensions.includes(ext)) {
                                    showModernAlert("❌ Invalid File",
                                        "Please upload only Excel (.xlsx, .xls) or CSV (.csv) files.");
                                    resetFileUpload();
                                    return;
                                }

                                fileName.textContent = file.name;
                                fileSize.textContent = `Size: ${(file.size / 1024 / 1024).toFixed(2)} MB`;
                                fileInfo.classList.add("show");
                                uploadBtn.disabled = false;
                            }

                            function resetFileUpload() {
                                fileInput.value = "";
                                fileInfo.classList.remove("show");
                                uploadBtn.disabled = true;
                            }

                            // Modern toast alert
                            function showModernAlert(title, message) {
                                const alertBox = document.createElement('div');
                                alertBox.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1e1e2f;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 10001;
            animation: fadeIn 0.3s ease-out;
        `;
                                alertBox.innerHTML = `<strong>${title}</strong><br><span style="color:#ccc;">${message}</span>`;
                                document.body.appendChild(alertBox);
                                setTimeout(() => {
                                    alertBox.style.opacity = "0";
                                    setTimeout(() => alertBox.remove(), 500);
                                }, 2500);
                            }
                        });
                    </script>

                    <script>
                        // Prevent selection of past dates
                        document.addEventListener("DOMContentLoaded", function() {
                            let today = new Date().toISOString().split("T")[0];
                            document.getElementById("date").setAttribute("min", today);
                        });

                        // Populate form with data when edit button is clicked
                        document.querySelectorAll(".edit-button").forEach(button => {
                            button.addEventListener("click", function() {
                                document.getElementById("edit_id").value = this.dataset.id;
                                document.getElementById("edit_year").value = this.dataset.year;
                                document.getElementById("edit_population").value = this.dataset.population;
                                document.getElementById("edit_births").value = this.dataset.births;
                                document.getElementById("edit_deaths").value = this.dataset.deaths;
                                document.getElementById("edit_infant").value = this.dataset.infant;
                                document.getElementById("edit_maternal").value = this.dataset.maternal;

                                editModal.style.display = "flex";
                            });
                        });

                        // Close modal when clicking close or cancel button
                        closeEditModalBtn.addEventListener("click", function() {
                            editModal.style.display = "none";
                        });

                        cancelEditModalBtn.addEventListener("click", function() {
                            editModal.style.display = "none";
                        });

                        // Close modal if clicked outside the modal content
                        window.addEventListener("click", function(event) {
                            if (event.target === editModal) {
                                editModal.style.display = "none";
                            }
                        });

                        // Add validation to edit form inputs
                        const editTotalDeathsInput = document.getElementById("edit_deaths");
                        const editInfantDeathsInput = document.getElementById("edit_infant");
                        const editMaternalDeathsInput = document.getElementById("edit_maternal");

                        function enforceEditDependency() {
                            let totalDeaths = parseInt(editTotalDeathsInput.value) || 0;
                            let infantDeaths = parseInt(editInfantDeathsInput.value) || 0;
                            let maternalDeaths = parseInt(editMaternalDeathsInput.value) || 0;
                            let maxAllowed = totalDeaths;

                            // Reset error states
                            editInfantDeathsInput.classList.remove('input-dependency-error');
                            editMaternalDeathsInput.classList.remove('input-dependency-error');

                            // Ensure infant and maternal deaths do not exceed total deaths
                            if (infantDeaths + maternalDeaths > maxAllowed) {
                                editInfantDeathsInput.classList.add('input-dependency-error');
                                editMaternalDeathsInput.classList.add('input-dependency-error');

                                showModernAlert("⚠️ Validation Error", "The sum of Infant and Maternal Deaths cannot exceed Total Deaths.");
                                editInfantDeathsInput.value = Math.max(0, maxAllowed - maternalDeaths);
                            }
                        }

                        editTotalDeathsInput.addEventListener("input", function() {
                            let totalDeaths = parseInt(this.value) || 0;
                            editInfantDeathsInput.max = totalDeaths;
                            editMaternalDeathsInput.max = totalDeaths;
                            enforceEditDependency();
                        });

                        editInfantDeathsInput.addEventListener("input", enforceEditDependency);
                        editMaternalDeathsInput.addEventListener("input", enforceEditDependency);
                    </script>

                    <script>
                        document.getElementById("printTable").addEventListener("click", function() {
                            let printContent = document.getElementById("dataTable").outerHTML;
                            let newWindow = window.open("", "", "width=800,height=600");

                            newWindow.document.write(`
        <html>
        <head>
            <title>Vital Statistics Records - Print</title>
            <style>
                body { 
                    font-family: 'Inter', Arial, sans-serif; 
                    margin: 20px;
                    color: #333;
                }
                table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    margin-top: 20px;
                }
                th, td { 
                    border: 1px solid #ddd; 
                    padding: 12px; 
                    text-align: left; 
                }
                th { 
                    background-color: #667eea; 
                    color: white; 
                    font-weight: 600;
                }
                tr:nth-child(even) { 
                    background-color: #f9f9f9; 
                }
                h1 {
                    color: #667eea;
                    text-align: center;
                    margin-bottom: 30px;
                }
                .print-date {
                    text-align: right;
                    color: #666;
                    font-size: 12px;
                    margin-bottom: 20px;
                }
                @media print {
                    .no-print, .pagination { display: none !important; }
                }
            </style>
        </head>
        <body>
            <h1>📊 Vital Statistics Records</h1>
            <div class="print-date">Printed on: ${new Date().toLocaleDateString()}</div>
            ${printContent}
        </body>
        </html>
    `);

                            newWindow.document.close();
                            newWindow.print();
                        });
                    </script>

                    <!-- CSS Animations -->
                    <style>
                        @keyframes fadeIn {
                            from {
                                opacity: 0;
                            }

                            to {
                                opacity: 1;
                            }
                        }

                        /* Loading spinner for buttons */
                        .loading {
                            position: relative;
                            pointer-events: none;
                        }

                        .loading::after {
                            content: '';
                            position: absolute;
                            width: 16px;
                            height: 16px;
                            margin: auto;
                            border: 2px solid transparent;
                            border-top-color: #ffffff;
                            border-radius: 50%;
                            animation: spin 1s linear infinite;
                            top: 0;
                            left: 0;
                            bottom: 0;
                            right: 0;
                        }

                        @keyframes spin {
                            0% {
                                transform: rotate(0deg);
                            }

                            100% {
                                transform: rotate(360deg);
                            }
                        }

                        /* Smooth transitions for form inputs */
                        .modern-form-control {
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                        }

                        .modern-form-control:hover {
                            background: rgba(255, 255, 255, 0.12);
                            transform: translateY(-1px);
                        }

                        /* Enhanced button hover effects */
                        .modern-btn {
                            position: relative;
                            overflow: hidden;
                        }

                        .modern-btn:active {
                            transform: translateY(0);
                            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
                        }

                        /* Success animation */
                        @keyframes successPulse {
                            0% {
                                transform: scale(1);
                            }

                            50% {
                                transform: scale(1.05);
                            }

                            100% {
                                transform: scale(1);
                            }
                        }

                        .success-animation {
                            animation: successPulse 0.6s ease-in-out;
                        }
                    </style>
                </div>
            </main>

            @include('staff.footer')
        </div>
    </div>

    @include('staff.js')

</body>

</html>

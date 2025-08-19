<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('staff.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>


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
            overflow: visible !important;
            /* Changed this line */
            position: relative;
            margin-bottom: 2rem;
            z-index: 1;
            /* Added this */
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

        .modern-form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.2);
            color: var(--text-primary);
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

        /* Modern Download Button */
        .modern-download-btn {
            background: var(--success-gradient);
            border: none;
            border-radius: 15px;
            padding: 14px 28px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modern-download-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .modern-download-btn:hover::before {
            left: 100%;
        }

       

        .modern-download-btn:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        .modern-download-btn i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .modern-download-btn:hover i {
            transform: translateY(-2px);
        }

        /* Modern Dropdown Menu */
        .modern-dropdown-menu {
            background: var(--dark-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-boder);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(31, 38, 135, 0.4);
            padding: 12px;
            margin-top: 8px;
            min-width: 200px;
            overflow: hidden;
            animation: dropdownSlideIn 0.3s ease-out;
        }

        @keyframes dropdownSlideIn {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Modern download Items */
        .modern-dropdown-item {
            color: var(--text-primary) !important;
            padding: 14px 20px;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 4px;
            position: relative;
            overflow: hidden;
        }

        .modern-dropdown-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .modern-dropdown-item:hover::before {
            left: 100%;
        }

        .modern-dropdown-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
            color: var(--text-primary) !important;
            box-shadow: 0 4px 15px rgba(31, 38, 135, 0.2);
        }

        .modern-dropdown-item:focus {
            background: rgba(255, 255, 255, 0.2);
            outline: none;
            color: var(--text-primary) !important;
        }

        /* Download Icons */
        .download-icon {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .file-csv {
            color: #43e97b;
            filter: drop-shadow(0 0 8px rgba(67, 233, 123, 0.3));
        }

        .file-pdf {
            color: #f5576c;
            filter: drop-shadow(0 0 8px rgba(245, 87, 108, 0.3));
        }

        .modern-dropdown-item:hover .download-icon {
            transform: scale(1.2);
        }

        /* Dropdown Arrow Animation */
        .dropdown-toggle::after {
            transition: transform 0.3s ease;
            margin-left: 8px;
        }

        .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }

        /* Custom Scrollbar for Dropdown */
        .modern-dropdown-menu::-webkit-scrollbar {
            width: 6px;
        }

        .modern-dropdown-menu::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .modern-dropdown-menu::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 10px;
        }

        .modern-dropdown-menu::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-gradient);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-download-btn {
                padding: 12px 20px;
                font-size: 0.9rem;
            }

            .modern-dropdown-menu {
                min-width: 160px;
            }

            .modern-dropdown-item {
                padding: 12px 16px;
            }
        }

        /* Demo Container */
        .demo-container {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            box-shadow: var(--shadow-glow);
            padding: 3rem;
            text-align: center;
        }

        .demo-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 2rem;
        }

       
        .dropdown-menu.show {
            z-index: 9999 !important;
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            transform: none !important;
        }

        /* Make sure parent containers don't interfere */
        .glass-card {
            overflow: visible !important;
        }

        /* If inside a table or other container */
        .table-responsive {
            overflow: visible !important;
        }

       

        /* Fix for dropdown appearing behind table */
        .dropdown {
            position: relative;
            z-index: 1050;
            /* Higher than table */
        }

        .dropdown-menu {
            z-index: 1055 !important;
            /* Even higher for the menu */
            position: absolute !important;
        }

        /* Ensure dropdown menu appears on top */
        .modern-dropdown-menu {
            z-index: 1055 !important;
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            transform: none !important;
        }

        /* Fix glass card overflow issues */
        .glass-card {
            overflow: visible !important;
           
            position: relative;
            z-index: 1;
        }

        .card-body {
            overflow: visible !important;
            position: relative;
        }

      
        .table-responsive {
            overflow: visible !important;
            /* Allow dropdown to show outside table */
        }

        .table-container {
            overflow-x: auto;
           
            overflow-y: visible;
            /* Allow vertical overflow for dropdowns */
        }

        /* Ensure table doesn't interfere with dropdowns */
        .modern-table {
            position: relative;
            z-index: 1;
        }

      
        .content {
            position: relative;
            z-index: auto;
        }

        .main {
            position: relative;
            z-index: auto;
        }

        /* Specific fix for your export dropdown */
        #exportDropdown {
            z-index: 1050;
        }

        .dropdown-menu.show {
            z-index: 1055 !important;
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            right: auto !important;
            transform: none !important;
            display: block !important;
        }

        /* Ensure dropdown parent has proper stacking context */
        .d-flex.align-items-center.gap-2.flex-wrap {
            position: relative;
            z-index: 1050;
        }

        /* Additional Bootstrap dropdown fixes */
        .dropdown-toggle::after {
            vertical-align: middle;
        }

        /* Fix for mobile responsiveness */
        @media (max-width: 768px) {
            .dropdown-menu {
                position: absolute !important;
                z-index: 1055 !important;
                width: auto !important;
                min-width: 160px !important;
            }
        }

        /* Fix for any potential backdrop issues */
        .dropdown-backdrop {
            z-index: 1040;
        }

        /* Ensure proper layering hierarchy */
        .wrapper {
            position: relative;
            z-index: auto;
        }

        .sidebar {
            z-index: 1030;
        }

        .header {
            z-index: 1020;
        }

        /* Specific fix for table wrapper if it exists */
        .table-wrapper,
        .dataTables_wrapper {
            overflow: visible !important;
        }

        /* Fix for any modal that might interfere */
        .modern-modal {
            z-index: 1060;
        }

        /* Ensure button group doesn't clip dropdown */
        .btn-group {
            position: relative;
        }

        .btn-group .dropdown-menu {
            z-index: 1055 !important;
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
                        <h1 class="page-title">Immunization Records</h1>
                        <div class="d-flex gap-2" style="width: 100%; max-width: 400px;">

                        </div>
                    </div>

                    <br><br>

                    <div class="col-12 col-lg-12 fade-in-up">
                        <div class="glass-card">
                            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <button class="modern-btn btn-success btn-sm" id="openModal">
                                        ➕ Add New Record
                                    </button>

                                    <span class="separator">|</span>

                                    <div class="modern-input-group input-group" style="width: 300px;">
                                        <span class="input-group-text bg-transparent"><i
                                                data-feather="search"></i></span>
                                        <input type="text" id="searchInput" name="search"
                                            class="form-control modern-form-control" placeholder="Search records..."
                                            style="border-left: none;">
                                    </div>

                                    <span class="separator">|</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <!-- Changed from dropdown to direct button -->
                                    <button class="modern-btn btn-secondary btn-sm" id="openImportModal">
                                        <i data-feather="upload"></i> Import
                                    </button>

                                    <button id="printTable" class="modern-btn btn-primary btn-sm">
                                        <i data-feather="printer"></i> Print
                                    </button>
                                    <!-- Replace your existing button code with this -->
                                    <div class="dropdown">
                                        <button class="modern-download-btn dropdown-toggle" type="button"
                                            id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </button>
                                        <ul class="dropdown-menu modern-dropdown-menu" aria-labelledby="exportDropdown">
                                            <li>
                                                <a class="dropdown-item modern-dropdown-item"
                                                    href="{{ route('immunization.export', 'csv') }}">
                                                    <i class="fas fa-file-csv download-icon file-csv"></i>
                                                    Download CSV
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item modern-dropdown-item"
                                                    href="{{ route('immunization.export', 'pdf') }}">
                                                    <i class="fas fa-file-pdf download-icon file-pdf"></i>
                                                    Download PDF
                                                </a>
                                            </li>
                                        </ul>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>

                    @include('immunization.immunization_table')

                    <!-- Initialize Feather Icons -->
                    <script>
                        feather.replace();
                    </script>

                    <!-- Add New Record Modal -->
                    <div id="customModal" class="modern-modal modal">
                        <div class="modern-modal-content modal-content">
                            <span class="modern-close close">&times;</span>
                            <h2>Add Immunization Record</h2>
                            <form action="{{ route('immunization.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="date" class="modern-form-label form-label">📅 Date of
                                        Immunization</label>
                                    <input type="date" class="modern-form-control form-control" id="date"
                                        name="date" required min="">
                                </div>

                                <div class="mb-3">
                                    <label for="vaccine_name" class="modern-form-label form-label">💊 Vaccine
                                        Name</label>
                                    <input type="text" class="modern-form-control form-control text-uppercase"
                                        id="vaccine_name" name="vaccine_name" required
                                        oninput="this.value = this.value.toUpperCase()">
                                </div>

                                <div class="mb-3">
                                    <label for="male_vaccinated" class="modern-form-label form-label">👨 Male
                                        Vaccinated</label>
                                    <input type="number" class="modern-form-control form-control" id="male_vaccinated"
                                        name="male_vaccinated" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="female_vaccinated" class="modern-form-label form-label">👩 Female
                                        Vaccinated</label>
                                    <input type="number" class="modern-form-control form-control"
                                        id="female_vaccinated" name="female_vaccinated" required min="0">
                                </div>

                                <div class="modern-modal-footer modal-footer">
                                    <button type="submit" class="modern-btn btn-primary">✅ Add Record</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Import Modal -->
                    <div id="importModal" class="modern-modal modal">
                        <div class="modern-modal-content modal-content">
                            <span class="modern-close close" id="closeImportModal">&times;</span>
                            <h2>Import Immunization Records</h2>
                            <form action="{{ route('immunization.import') }}" method="POST"
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
                                        <strong>Required columns:</strong> Date, Vaccine Name, Male Vaccinated, Female
                                        Vaccinated
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

                    <!-- Modern Edit Modal -->
                    <div id="editModal" class="modern-modal modal" style="display: none;">
                        <div class="modern-modal-content modal-content">
                            <span class="modern-close close">&times;</span>
                            <h2>✏️ Edit Immunization Data</h2>
                            <form id="updateForm" action="{{ route('immunization.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit_id" name="id">

                                <div class="mb-3">
                                    <label for="edit_vaccine" class="modern-form-label form-label">💊 Vaccine
                                        Name</label>
                                    <input type="text" class="modern-form-control form-control" id="edit_vaccine"
                                        name="vaccine_name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_date" class="modern-form-label form-label">📅 Date</label>
                                    <input type="date" class="modern-form-control form-control" id="edit_date"
                                        name="date" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_male" class="modern-form-label form-label">👨 Male
                                        Vaccinated</label>
                                    <input type="number" class="modern-form-control form-control" id="edit_male"
                                        name="male_vaccinated" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_female" class="modern-form-label form-label">👩 Female
                                        Vaccinated</label>
                                    <input type="number" class="modern-form-control form-control" id="edit_female"
                                        name="female_vaccinated" required>
                                </div>

                                <div class="modern-modal-footer modal-footer">
                                    <button type="button" id="cancelEditModal" class="modern-btn btn-secondary">❌
                                        Cancel</button>
                                    <button type="submit" class="modern-btn btn-primary">💾 Update</button>
                                </div>
                            </form>
                        </div>
                    </div>

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
                        document.getElementById("printTable").addEventListener("click", function() {
                            let printContent = document.getElementById("dataTable").outerHTML;
                            let newWindow = window.open("", "", "width=800,height=600");

                            newWindow.document.write(`
                                <html>
                                <head>
                                    <title>Print</title>
                                    <style>
                                        @media print {
                                            .no-print, .pagination { display: none !important; }
                                        }
                                    </style>
                                </head>
                                <body>${printContent}</body>
                                </html>
                            `);

                            newWindow.document.close();
                            newWindow.print();
                        });
                    </script>

                    <!-- Initialize Feather Icons -->
                    <script>
                        feather.replace();
                    </script>

                    <!-- Modern Modal Structure -->
                    <!-- <div id="customModal" class="modern-modal modal">
                        <div class="modern-modal-content modal-content">
                            <span class="modern-close close">&times;</span>
                            <h2>🩹 Add Immunization Record</h2>
                            <form action="{{ route('immunization.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="date" class="modern-form-label form-label">📅 Date of Immunization</label>
                                    <input type="date" class="modern-form-control form-control" id="date" name="date" required min="">
                                </div>

                                <div class="mb-3">
                                    <label for="vaccine_name" class="modern-form-label form-label">💊 Vaccine Name</label>
                                    <input type="text" class="modern-form-control form-control text-uppercase" id="vaccine_name" name="vaccine_name" required oninput="this.value = this.value.toUpperCase()">
                                </div>

                                <div class="mb-3">
                                    <label for="male_vaccinated" class="modern-form-label form-label">👨 Male Vaccinated</label>
                                    <input type="number" class="modern-form-control form-control" id="male_vaccinated" name="male_vaccinated" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="female_vaccinated" class="modern-form-label form-label">👩 Female Vaccinated</label>
                                    <input type="number" class="modern-form-control form-control" id="female_vaccinated" name="female_vaccinated" required min="0">
                                </div>

                                <div class="modern-modal-footer modal-footer">
                                    <button type="submit" class="modern-btn btn-primary">✅ Add Record</button>
                                </div>
                            </form>
                        </div>
                    </div> -->

                    <!-- Modern Edit Modal -->
                    <!-- <div id="editModal" class="modern-modal modal" style="display: none;">
                        <div class="modern-modal-content modal-content">
                            <span class="modern-close close">&times;</span>
                            <h2>✏️ Edit Immunization Data</h2>
                            <form id="updateForm" action="{{ route('immunization.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit_id" name="id">

                                <div class="mb-3">
                                    <label for="edit_vaccine" class="modern-form-label form-label">💊 Vaccine Name</label>
                                    <input type="text" class="modern-form-control form-control" id="edit_vaccine" name="vaccine_name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_date" class="modern-form-label form-label">📅 Date</label>
                                    <input type="date" class="modern-form-control form-control" id="edit_date" name="date" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_male" class="modern-form-label form-label">👨 Male Vaccinated</label>
                                    <input type="number" class="modern-form-control form-control" id="edit_male" name="male_vaccinated" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_female" class="modern-form-label form-label">👩 Female Vaccinated</label>
                                    <input type="number" class="modern-form-control form-control" id="edit_female" name="female_vaccinated" required>
                                </div>

                                <div class="modern-modal-footer modal-footer">
                                    <button type="button" id="cancelEditModal" class="modern-btn btn-secondary">❌ Cancel</button>
                                    <button type="submit" class="modern-btn btn-primary">💾 Update</button>
                                </div>
                            </form>
                        </div>
                    </div> -->

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            setTimeout(() => {
                                var modal = document.getElementById("customModal");
                                var openModalBtn = document.getElementById("openModal");
                                var closeModalBtn = document.querySelector(".close");

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
                        });
                    </script>

                    <script>
                        // Prevent selection of past dates
                        document.addEventListener("DOMContentLoaded", function() {
                            let today = new Date().toISOString().split("T")[0];
                            document.getElementById("date").setAttribute("min", today);
                        });
                    </script>

                    <script>
                        document.getElementById("printTable").addEventListener("click", function() {
                            let printContent = document.getElementById("dataTable").outerHTML;
                            let newWindow = window.open("", "", "width=800,height=600");

                            newWindow.document.write(`
                                <html>
                                <head>
                                    <title>Print</title>
                                    <style>
                                        @media print {
                                            .no-print, .pagination { display: none !important; }
                                        }
                                    </style>
                                </head>
                                <body>${printContent}</body>
                                </html>
                            `);

                            newWindow.document.close();
                            newWindow.print();
                        });
                    </script>


                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.querySelectorAll(".delete-button").forEach(button => {
                                button.addEventListener("click", function() {
                                    const dataId = this.dataset.id;
                                    const tableRow = this.closest("tr"); // Save reference to the row

                                    // Modern confirmation overlay
                                    const confirmOverlay = document.createElement('div');
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
                <p style="margin-bottom: 2rem; font-size: 1rem; color: #ccc;">Are you sure you want to delete this data? This action cannot be undone.</p>
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
                                   fetch(`${window.location.origin}/cho-dash/immunization/delete/${dataId}`, {
    method: "DELETE",
    headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        "Content-Type": "application/json"
    }
})

                                            .then(response => response.json())
                                            .then(data => {
                                                confirmOverlay.remove();
                                                if (data.success) {
                                                    // Remove the row from the table without reloading
                                                    tableRow.remove();
                                                    showModernAlert("✅ Success",
                                                        "Data deleted successfully!");
                                                } else {
                                                    showModernAlert("❌ Error",
                                                        "Failed to delete data.");
                                                }
                                            })
                                            .catch(error => {
                                                confirmOverlay.remove();
                                                console.error("Error:", error);
                                                showModernAlert("❌ Error", "Something went wrong.");
                                            });
                                    });
                                });
                            });

                            // Simple modern alert
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
                                let rowText = "";
                                let found = false;

                                // Collect all cell text & check if search matches any
                                cells.forEach(cell => {
                                    let text = cell.innerText.toLowerCase();
                                    if (text.includes(searchValue)) {
                                        found = true;
                                    }
                                });

                                // Show or hide row based on match
                                if (searchValue === "" || found) {
                                    row.style.display = "";
                                } else {
                                    row.style.display = "none";
                                }
                            });
                        });
                    </script>


                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const editModal = document.getElementById("editModal");
                            const closeEditModalBtn = document.querySelector("#editModal .close");
                            const cancelEditModalBtn = document.getElementById("cancelEditModal");

                            // Open modal and populate form
                            document.querySelectorAll(".edit-button").forEach(button => {
                                button.addEventListener("click", function() {
                                    document.getElementById("edit_id").value = this.dataset.id;
                                    document.getElementById("edit_vaccine").value = this.dataset.vaccine;
                                    document.getElementById("edit_date").value = this.dataset.date;
                                    document.getElementById("edit_male").value = this.dataset.male;
                                    document.getElementById("edit_female").value = this.dataset.female;

                                    editModal.style.display = "flex";
                                });
                            });

                            // Close modal on 'X' or Cancel
                            closeEditModalBtn.addEventListener("click", () => editModal.style.display = "none");
                            cancelEditModalBtn.addEventListener("click", () => editModal.style.display = "none");

                            // Close modal when clicking outside the content
                            window.addEventListener("click", (event) => {
                                if (event.target === editModal) {
                                    editModal.style.display = "none";
                                }
                            });

                            // Handle form submission with AJAX
                            document.getElementById("updateForm").addEventListener("submit", function(event) {
                                event.preventDefault();

                                let formData = new FormData(this);
                                formData.append('_method', 'PUT');

                                fetch(`/immunization/update`, {
                                        method: "POST",
                                        headers: {
                                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                            "X-Requested-With": "XMLHttpRequest",
                                        },
                                        body: formData,
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {

                                            location.reload();
                                        } else {
                                            alert("Failed to update record: " + (data.message || "Unknown error."));
                                        }
                                    })
                                    .catch(error => {
                                        console.error("Error:", error);
                                        alert("An error occurred while updating the record.");
                                    });
                            });
                        });
                    </script>

                    <!-- Initialize Feather Icons -->
                    <script>
                        feather.replace();
                    </script>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var modal = document.getElementById("customModal");
                            var openModalBtn = document.getElementById("openModal");
                            var closeModalBtn = document.querySelector(".close");

                            // Open Modal
                            openModalBtn.addEventListener("click", function() {
                                modal.style.display = "flex";
                            });

                            // Close Modal
                            closeModalBtn.addEventListener("click", function() {
                                modal.style.display = "none";
                            });

                            // Close if clicked outside the modal
                            window.addEventListener("click", function(event) {
                                if (event.target === modal) {
                                    modal.style.display = "none";
                                }
                            });
                        });
                    </script>
                </div>
            </main>

            @include('staff.footer')
        </div>
    </div>

    @include('staff.js')

</body>

</html>

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
            text-decoration: none;
            display: inline-block;
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
            color: white;
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

        /* Select elements get their own color */
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

        /* Modern Dropdown */
        .modern-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            box-shadow: var(--shadow-glow);
            padding: 1rem;
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

        /* Additional animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
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
                        <h1 class="page-title">Population Records</h1>
                        <div class="d-flex gap-2" style="width: 100%; max-width: 400px;"></div>
                    </div>

                    <br><br>

                    <div class="col-12 col-lg-12 fade-in-up">
                        <div class="glass-card">
                            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <!-- Add Record Button -->
                                    <button class="modern-btn btn-success btn-sm" id="openModal">
                                        ➕ Add New Record
                                    </button>

                                     <button class="modern-btn btn-danger btn-sm" id="deleteAllBtn">
    <i data-feather="trash-2"></i> Delete All
</button>

<span class="separator">|</span>

<!-- 2. ADD THIS CSS TO YOUR EXISTING STYLE SECTION -->
<style>
/* Add this to your existing CSS */
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.modern-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--card-bg);
    backdrop-filter: blur(16px);
    border: 1px solid var(--glass-border);
    border-radius: 15px;
    padding: 1rem 1.5rem;
    color: var(--text-primary);
    box-shadow: var(--shadow-glow);
    z-index: 10001;
    animation: fadeIn 0.3s ease-out;
    max-width: 400px;
}

.modern-alert.success {
    border-left: 4px solid #10b981;
}

.modern-alert.error {
    border-left: 4px solid #ef4444;
}

.modern-alert.warning {
    border-left: 4px solid #f59e0b;
}
</style>

<!-- 3. ADD THIS JAVASCRIPT AT THE END OF YOUR DOCUMENT (before closing </body> tag) -->
<script>
// Delete All Functionality - Add this to your existing JavaScript
document.addEventListener("DOMContentLoaded", function() {
    // Delete All Button Event Listener
    document.getElementById('deleteAllBtn').addEventListener('click', function() {
        const tableBody = document.querySelector('#dataTable tbody');
        const rowCount = tableBody ? tableBody.children.length : 0;

        if (rowCount === 0) {
            showModernAlert("⚠️ Warning", "No data to delete.", "warning");
            return;
        }

        // Create modern confirmation modal
        const confirmOverlay = document.createElement('div');
        confirmOverlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            z-index: 10000;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-out;
        `;

        const confirmBox = document.createElement('div');
        confirmBox.style.cssText = `
            background: linear-gradient(135deg, #1e1e2f, #2a2a3e);
            border-radius: 25px;
            padding: 2.5rem;
            max-width: 480px;
            width: 90%;
            text-align: center;
            color: #fff;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            animation: modalSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        `;

        confirmBox.innerHTML = `
            <div style="margin-bottom: 1.5rem;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ff4757, #ff3838); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; animation: pulse 2s infinite;">
                    🗑️
                </div>
                <h3 style="margin-bottom: 1rem; font-size: 1.6rem; background: linear-gradient(135deg, #ff4757, #ff6b7a); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Confirm Delete All</h3>
                <p style="margin-bottom: 2rem; font-size: 1.1rem; color: #ccc; line-height: 1.5;">
                    This action will permanently delete all <strong>${rowCount} records</strong> from the immunization table. 
                    <br><br>
                    <span style="color: #ff6b7a; font-weight: 600;">⚠️ This action cannot be undone!</span>
                </p>
            </div>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <button id="cancelDeleteAll" style="background: linear-gradient(135deg, #6c757d, #8a94a6); border: none; border-radius: 15px; padding: 12px 24px; color: white; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;">
                    <span>❌</span> Cancel
                </button>
                <button id="confirmDeleteAll" style="background: linear-gradient(135deg, #ff4757, #ff3838); border: none; border-radius: 15px; padding: 12px 24px; color: white; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);">
                    <span>🗑️</span> Delete All
                </button>
            </div>
        `;

        confirmOverlay.appendChild(confirmBox);
        document.body.appendChild(confirmOverlay);

        // Add hover effects
        const cancelBtn = confirmBox.querySelector("#cancelDeleteAll");
        const confirmBtn = confirmBox.querySelector("#confirmDeleteAll");

        cancelBtn.addEventListener('mouseover', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 6px 20px rgba(108, 117, 125, 0.4)';
        });

        cancelBtn.addEventListener('mouseout', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });

        confirmBtn.addEventListener('mouseover', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 8px 25px rgba(255, 71, 87, 0.5)';
        });

        confirmBtn.addEventListener('mouseout', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 15px rgba(255, 71, 87, 0.3)';
        });

        // Cancel action
        cancelBtn.addEventListener("click", () => {
            confirmOverlay.remove();
        });

        // Confirm action - Delete all records
        confirmBtn.addEventListener("click", () => {
            // Show loading state
            confirmBtn.innerHTML = '<span>⏳</span> Deleting...';
            confirmBtn.disabled = true;
            cancelBtn.disabled = true;

            // Make the delete all request
           fetch("{{ url('/population/delete-all') }}", {
    method: "DELETE",
    headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        "Accept": "application/json",
        "Content-Type": "application/json"
    }
})
            .then(response => response.json())
            .then(data => {
                confirmOverlay.remove();
                if (data.success) {
                    // Clear the table body
                    tableBody.innerHTML = '';
                    
                    // Update pagination info
                    const paginationInfo = document.querySelector('.pagination-container p');
                    if (paginationInfo) {
                        paginationInfo.textContent = 'Showing 0 to 0 of 0 results';
                    }
                    
                    // Hide pagination
                    const pagination = document.querySelector('.pagination');
                    if (pagination) {
                        pagination.style.display = 'none';
                    }
                    
                    // Show no data message
                    const tableContainer = document.querySelector('#dataTable .card');
                    if (tableContainer && rowCount > 0) {
                        tableContainer.innerHTML = `
                            <div class="no-data-message" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
                                <p style="color: #374151; font-size: 18px; margin: 0; font-weight: 500;">No immunization data available.</p>
                            </div>
                        `;
                    }
                    
                    showModernAlert("✅ Success", `Successfully deleted all ${data.deleted_count} records!`, "success");
                } else {
                    showModernAlert("❌ Error", data.message || "Failed to delete records.", "error");
                }
            })
            .catch(error => {
                confirmOverlay.remove();
                console.error("Error:", error);
                showModernAlert("❌ Error", "Something went wrong while deleting records.", "error");
            });
        });

        // Close on outside click
        confirmOverlay.addEventListener('click', function(e) {
            if (e.target === confirmOverlay) {
                confirmOverlay.remove();
            }
        });
    });

    // Enhanced showModernAlert function (if not already exists)
    if (typeof window.showModernAlert === 'undefined') {
        window.showModernAlert = function(title, message, type = 'success') {
            const alertBox = document.createElement('div');
            alertBox.className = `modern-alert ${type}`;
            alertBox.innerHTML = `<strong>${title}</strong><br><span style="color:#ccc;">${message}</span>`;
            document.body.appendChild(alertBox);
            
            setTimeout(() => {
                alertBox.style.opacity = "0";
                alertBox.style.transform = "translateX(100%)";
                setTimeout(() => {
                    if (alertBox.parentNode) {
                        alertBox.remove();
                    }
                }, 500);
            }, 3000);
        };
    }
});
</script>
          

                                    <!-- Vertical Bar Separator -->
                                    <span class="separator">|</span>

                                    <!-- Search Input -->
                                    <div class="modern-input-group input-group" style="width: 300px;">
                                        <span class="input-group-text bg-transparent"><i
                                                data-feather="search"></i></span>
                                        <input type="text" id="searchInput" name="search"
                                            class="form-control modern-form-control" placeholder="Search records..."
                                            style="border-left: none;">
                                    </div>

                                    <span class="separator">|</span>
                                </div>

                                <!-- Right Side Buttons -->
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <!-- Import Button -->
                                    <button class="modern-btn btn-secondary btn-sm" id="openImportModal">
                                        <i data-feather="upload"></i> Import
                                    </button>

                                    <!-- Print Button -->
                                    <button id="printTable" class="modern-btn btn-primary btn-sm">
                                        <i data-feather="printer"></i> Print
                                    </button>

                                    <!-- Download Button -->
                                    <div class="dropdown">
                                        <button class="modern-download-btn dropdown-toggle" type="button"
                                            id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </button>
                                        <ul class="dropdown-menu modern-dropdown-menu" aria-labelledby="exportDropdown">
                                            <li>
                                                <a class="dropdown-item modern-dropdown-item"
                                                    href="{{ route('population.export', 'csv') }}">
                                                    <i class="fas fa-file-csv download-icon file-csv"></i>
                                                    Download CSV
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item modern-dropdown-item"
                                                    href="{{ route('population.export', 'pdf') }}">
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

                    @include('populationstatistics.population_table')

                    <!-- Initialize Feather Icons -->
                    <script>
                        feather.replace();
                    </script>

                    <!-- Add New Record Modal -->
                    <div id="customModal" class="modern-modal modal">
                        <div class="modern-modal-content modal-content">
                            <span class="modern-close close">&times;</span>
                            <h2>Add Population Record</h2>
                            <form action="{{ route('population.store') }}" method="POST">
                                @csrf

                                <!-- Barangay Dropdown -->
                                <div class="mb-3">
                                    <label for="location" class="modern-form-label form-label">🏘️ Location
                                        (Barangay)</label>
                                    <select class="modern-form-control form-control" id="location" name="location"
                                        required>
                                        <option value="" disabled selected>Select Barangay</option>
                                        <option value="Bacayao Norte">Bacayao Norte</option>
                                        <option value="Bacayao Sur">Bacayao Sur</option>
                                        <option value="Barangay I (T. Bugallon)">Barangay I (T. Bugallon)</option>
                                        <option value="Barangay II (Nueva)">Barangay II (Nueva)</option>
                                        <option value="Barangay IV (Zamora)">Barangay IV (Zamora)</option>
                                        <option value="Bolosan">Bolosan</option>
                                        <option value="Bonuan Binloc">Bonuan Binloc</option>
                                        <option value="Bonuan Boquig">Bonuan Boquig</option>
                                        <option value="Bonuan Gueset">Bonuan Gueset</option>
                                        <option value="Calmay">Calmay</option>
                                        <option value="Carael">Carael</option>
                                        <option value="Caranglaan">Caranglaan</option>
                                        <option value="Herrero">Herrero</option>
                                        <option value="Lasip Chico">Lasip Chico</option>
                                        <option value="Lasip Grande">Lasip Grande</option>
                                        <option value="Lomboy">Lomboy</option>
                                        <option value="Lucao">Lucao</option>
                                        <option value="Malued">Malued</option>
                                        <option value="Mamalingling">Mamalingling</option>
                                        <option value="Mangin">Mangin</option>
                                        <option value="Mayombo">Mayombo</option>
                                        <option value="Pantal">Pantal</option>
                                        <option value="Poblacion Oeste">Poblacion Oeste</option>
                                        <option value="Pogo Chico">Pogo Chico</option>
                                        <option value="Pogo Grande">Pogo Grande</option>
                                        <option value="Pugaro Suit">Pugaro Suit</option>
                                        <option value="Salapingao">Salapingao</option>
                                        <option value="Salisay">Salisay</option>
                                        <option value="Tambac">Tambac</option>
                                        <option value="Tapuac">Tapuac</option>
                                        <option value="Tebeng">Tebeng</option>
                                    </select>
                                </div>

                                <!-- Date Picker -->
                                <div class="mb-3">
                                    <label for="date" class="modern-form-label form-label">📅 Date</label>
                                    <input type="date" class="modern-form-control form-control" id="date"
                                        name="date" required>
                                </div>

                                <!-- Total Population -->
                                <div class="mb-3">
                                    <label for="population" class="modern-form-label form-label">👥 Total
                                        Population</label>
                                    <input type="number" class="modern-form-control form-control" id="population"
                                        name="population" required min="0">
                                </div>

                                <!-- Submit Button -->
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
                            <h2>Import Population Records</h2>
                            <form action="{{ route('population.import') }}" method="POST"
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
                                        <strong>Required columns:</strong> Location, Date, Population
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

                    <!-- Edit Modal -->
                    <div id="editModal" class="modern-modal modal" style="display: none;">
                        <div class="modern-modal-content modal-content">
                            <span class="modern-close close">&times;</span>
                            <h2>✏️ Edit Population Record</h2>
                            <form id="updateForm" action="{{ route('population.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit_id" name="id">

                                <!-- Barangay Dropdown (Location) -->
                                <div class="mb-3">
                                    <label for="edit_location" class="modern-form-label form-label">🏘️ Location
                                        (Barangay)</label>
                                    <select class="modern-form-control form-control" id="edit_location"
                                        name="location" required>
                                        <option value="" disabled>Select Barangay</option>
                                        <option value="Bacayao Norte">Bacayao Norte</option>
                                        <option value="Bacayao Sur">Bacayao Sur</option>
                                        <option value="Barangay I (T. Bugallon)">Barangay I (T. Bugallon)</option>
                                        <option value="Barangay II (Nueva)">Barangay II (Nueva)</option>
                                        <option value="Barangay IV (Zamora)">Barangay IV (Zamora)</option>
                                        <option value="Bolosan">Bolosan</option>
                                        <option value="Bonuan Binloc">Bonuan Binloc</option>
                                        <option value="Bonuan Boquig">Bonuan Boquig</option>
                                        <option value="Bonuan Gueset">Bonuan Gueset</option>
                                        <option value="Calmay">Calmay</option>
                                        <option value="Carael">Carael</option>
                                        <option value="Caranglaan">Caranglaan</option>
                                        <option value="Herrero">Herrero</option>
                                        <option value="Lasip Chico">Lasip Chico</option>
                                        <option value="Lasip Grande">Lasip Grande</option>
                                        <option value="Lomboy">Lomboy</option>
                                        <option value="Lucao">Lucao</option>
                                        <option value="Malued">Malued</option>
                                        <option value="Mamalingling">Mamalingling</option>
                                        <option value="Mangin">Mangin</option>
                                        <option value="Mayombo">Mayombo</option>
                                        <option value="Pantal">Pantal</option>
                                        <option value="Poblacion Oeste">Poblacion Oeste</option>
                                        <option value="Pogo Chico">Pogo Chico</option>
                                        <option value="Pogo Grande">Pogo Grande</option>
                                        <option value="Pugaro Suit">Pugaro Suit</option>
                                        <option value="Salapingao">Salapingao</option>
                                        <option value="Salisay">Salisay</option>
                                        <option value="Tambac">Tambac</option>
                                        <option value="Tapuac">Tapuac</option>
                                        <option value="Tebeng">Tebeng</option>
                                    </select>
                                </div>

                                <!-- Date -->
                                <div class="mb-3">
                                    <label for="edit_year" class="modern-form-label form-label">📅 Date</label>
                                    <input type="date" class="modern-form-control form-control" id="edit_year"
                                        name="year" required>
                                </div>

                                <!-- Total Population -->
                                <div class="mb-3">
                                    <label for="edit_population" class="modern-form-label form-label">👥 Total
                                        Population</label>
                                    <input type="number" class="modern-form-control form-control"
                                        id="edit_population" name="total_population" required min="0">
                                </div>

                                <div class="modern-modal-footer modal-footer">
                                    <button type="button" id="cancelEditModal" class="modern-btn btn-secondary">❌
                                        Cancel</button>
                                    <button type="submit" class="modern-btn btn-primary">💾 Update Record</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- JavaScript Section -->

                    <script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('customModal');
    const cancelBtn = document.getElementById('cancelCustomModal'); // cancel button
    const topCloseBtn = document.getElementById('closeCustomModalTop'); // X button
    const form = document.querySelector("form[action='{{ route('population.store') }}']");

    // Form submit (AJAX)
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        fetch(form.action, {
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
                showModernAlert("✅ Success", data.message || "Population data added successfully!");
                setTimeout(() => {
                    form.reset();
                    closeModal();
                    location.reload();
                }, 1400);
            } else {
                // highlight location field if duplicate
                const locationInput = form.querySelector("[name='location']");
                if (data.message && data.message.includes('location')) {
                    locationInput.classList.add("input-error"); // add red border CSS class
                }
                showModernAlert("❌ Error", data.message || "Failed to save.");
            }
        })
        .catch(err => {
            console.error(err);
            showModernAlert("❌ Error", "An error occurred while saving.");
        });
    });

    // Close modal function
    function closeModal() {
        modal.style.display = 'none';
    }

    cancelBtn && cancelBtn.addEventListener('click', closeModal);
    topCloseBtn && topCloseBtn.addEventListener('click', closeModal);

    window.addEventListener('click', function(ev) {
        if (ev.target === modal) closeModal();
    });

    document.addEventListener('keydown', function(ev) {
        if (ev.key === 'Escape' || ev.key === 'Esc') {
            if (getComputedStyle(modal).display !== 'none') closeModal();
        }
    });
});
</script>


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

                            // Set minimum date to today
                            let today = new Date().toISOString().split('T')[0];
                            document.getElementById("date").setAttribute("min", today);
                        });

                        // Update Form Submission
                        document.getElementById("updateForm").addEventListener("submit", function(event) {
                            event.preventDefault();

                            let formData = new FormData(this);
                            formData.append('_method', 'PUT');

                            fetch(`/public/population/update`, {
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
                                        showModernAlert("✅ Success", "Record updated successfully!");
                                        location.reload();
                                    } else {
                                        showModernAlert("❌ Error", "Failed to update record: " + (data.message ||
                                            "Unknown error."));
                                    }
                                })
                                .catch(error => {
                                    console.error("Error:", error);
                                    showModernAlert("❌ Error", "An error occurred while updating the record.");
                                });
                        });

                        // Delete Functionality
                        document.addEventListener("DOMContentLoaded", function() {
                            document.querySelectorAll(".delete-button").forEach(button => {
                                button.addEventListener("click", function() {
                                    const dataId = this.dataset.id;
                                    const tableRow = this.closest("tr");

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
                                    confirmBox.querySelector("#confirmDelete").addEventListener("click", () => {
                                        fetch(`/public/population/delete/${dataId}`, {
                                                method: "DELETE",
                                                headers: {
                                                    "X-CSRF-TOKEN": document.querySelector(
                                                        'meta[name="csrf-token"]').content,
                                                    "Content-Type": "application/json"
                                                }
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                confirmOverlay.remove();
                                                if (data.success) {
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
                        });

                        // Search Functionality
                        document.getElementById("searchInput").addEventListener("input", function() {
                            let searchValue = this.value.toLowerCase();
                            let rows = document.querySelectorAll("#dataTable tbody tr");

                            rows.forEach(row => {
                                let cells = row.querySelectorAll("td");
                                let found = false;

                                cells.forEach(cell => {
                                    let text = cell.innerText.toLowerCase();
                                    if (text.includes(searchValue)) {
                                        found = true;
                                    }
                                });

                                if (searchValue === "" || found) {
                                    row.style.display = "";
                                } else {
                                    row.style.display = "none";
                                }
                            });
                        });

                        // Edit Modal
                        document.addEventListener("DOMContentLoaded", function() {
                            const editModal = document.getElementById("editModal");
                            const closeEditModalBtn = document.querySelector("#editModal .close");
                            const cancelEditModalBtn = document.getElementById("cancelEditModal");

                            // Show and populate modal
                            document.querySelectorAll(".edit-button").forEach(button => {
                                button.addEventListener("click", function() {
                                    document.getElementById("edit_id").value = this.dataset.id;
                                    document.getElementById("edit_year").value = this.dataset.year;
                                    document.getElementById("edit_population").value = this.dataset.population;

                                    // Set the correct selected option in the dropdown
                                    const locationDropdown = document.getElementById("edit_location");
                                    const selectedLocation = this.dataset.location;
                                    for (let option of locationDropdown.options) {
                                        if (option.value === selectedLocation) {
                                            option.selected = true;
                                            break;
                                        }
                                    }

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
                        });

                        // Print Functionality
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

                        // Modern alert function for global use
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

                        // Initialize Feather Icons
                        feather.replace();
                    </script>
                </div>
            </main>

            @include('staff.footer')
        </div>
    </div>

    @include('staff.js')

</body>

</html>

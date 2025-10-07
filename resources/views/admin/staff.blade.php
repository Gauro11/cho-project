<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('staff.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
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
            overflow: visible;
            position: relative;
            margin-bottom: 2rem;
            z-index: 1;
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
            overflow: visible;
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
            text-decoration: none;
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

        .modern-input-group input {
            background: transparent;
            border: none;
            color: var(--text-primary);
            padding: 12px 20px;
        }

        .modern-input-group input:focus {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-primary);
            box-shadow: none;
        }

        .modern-input-group input::placeholder {
            color: var(--text-secondary);
        }

        /* Modern Table Styles */
        .modern-table {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modern-table thead th {
            background: linear-gradient(135deg, #1f2937, #374151);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            padding: 20px 15px;
            border: none;
        }

        .modern-table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 500;
            color: #374151;
            background: white;
        }

        .modern-table tbody tr {
            background: white;
            transition: all 0.3s ease;
        }

        .modern-table tbody tr:hover {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.03), rgba(124, 58, 237, 0.03));
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Action Buttons */
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #d97706, #b45309);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Modern Pagination */
        /* Modern Pagination Container - WHITE VERSION */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    padding: 20px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.95); /* Changed to white */
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    margin-top: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.pagination-container p {
    margin: 0;
    color: #374151; /* Changed text color to dark gray for better readability */
    font-weight: 500;
    font-size: 14px;
}

.custom-pagination {
    display: flex;
    list-style: none;
    padding: 0;
    justify-content: center;
    margin: 0;
}

.custom-pagination .page-item {
    margin: 0 3px;
}

.custom-pagination .page-link {
    color: white !important;
    background: rgba(255, 255, 255, 1); /* Fully white background */
    backdrop-filter: blur(10px);
    border: 1px solid rgba(79, 70, 229, 0.2);
    border-radius: 12px;
    padding: 10px 16px;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    text-decoration: none;
}

.custom-pagination .page-link:hover {
    background: rgba(255, 255, 255, 1);
    border-color: #4f46e5;
    color: #4f46e5 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
}

.custom-pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border-color: white;
    color: white !important;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
}

.custom-pagination .page-item.disabled .page-link {
    background: rgba(255, 255, 255, 0.7);
    border-color: rgba(203, 213, 225, 0.5);
    color: rgba(107, 114, 128, 0.6) !important;
    cursor: not-allowed;
    box-shadow: none;
}

/* Media Query for Mobile */
@media (max-width: 768px) {
    .pagination-container {
        flex-direction: column;
        gap: 15px;
        padding: 15px;
    }

    .custom-pagination {
        justify-content: center;
        flex-wrap: wrap;
    }
}

        /* Modern Modal */
        .modal {
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

        .modal-content {
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

        .modal-content h2 {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .close {
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

        .close:hover {
            background: var(--secondary-gradient);
            transform: rotate(90deg);
        }

        /* Modern Form Controls */
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 12px 20px;
            color: var(--text-primary);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.2);
            color: var(--text-primary);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 2rem;
            gap: 10px;
        }

        /* Highlight Search */
        .highlight {
            background: linear-gradient(135deg, #feca57 0%, #ff9ff3 100%);
            color: #000;
            font-weight: bold;
            padding: 2px 4px;
            border-radius: 4px;
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

        /* No data message */
        .no-data-message {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .no-data-message p {
            color: #374151;
            font-size: 18px;
            margin: 0;
            font-weight: 500;
        }

        /* Separator */
        .separator {
            color: var(--text-secondary);
            font-weight: bold;
            margin: 0 10px;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.8rem;
            }

            .modal-content {
                width: 95%;
                padding: 1.5rem;
            }

            .content {
                padding: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .d-flex.justify-content-between.align-items-center {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .pagination-container {
                flex-direction: column;
                gap: 15px;
            }

            .custom-pagination {
                justify-content: center;
            }
        }

        @media print {
            .no-print,
            .pagination {
                display: none !important;
            }
        }

        /* Wrapper positioning */
        .wrapper {
            position: relative;
            z-index: auto;
        }

        .main {
            position: relative;
            z-index: auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('admin.sidebar')

        <div class="main">
            @include('staff.header')
            <main class="content">
                <div class="container-fluid p-0">

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h1 class="page-title">Staff Management</h1>
                    </div>

                    <br><br>

                    <div class="col-12 col-lg-12 fade-in-up">
                        <div class="glass-card">
                            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <button class="modern-btn btn-success btn-sm" id="openModal">
                                        ➕ Add New Staff
                                    </button>

                                    <span class="separator">|</span>

                                    <div class="modern-input-group input-group" style="width: 300px;">
                                        <span class="input-group-text"><i data-feather="search"></i></span>
                                        <input type="text" id="searchInput" class="form-control" placeholder="Search staff...">
                                    </div>

                                    <span class="separator">|</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <button id="printTable" class="modern-btn btn-primary btn-sm">
                                        <i data-feather="printer"></i> Print
                                    </button>
                                    <button id="downloadBtn" class="modern-btn btn-secondary btn-sm">
                                        <i data-feather="download"></i> Download
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Staff Table -->
                    <div class="row fade-in-up">
                        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                            <div class="glass-card flex-fill" style="width: 100%;">
                                <table class="table modern-table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Staff ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Position</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($staff as $person)
                                            <tr>
                                                <td>{{ strtoupper($person->staff_id) }}</td>
                                                <td>{{ strtoupper($person->first_name) }}</td>
                                                <td>{{ strtoupper($person->last_name) }}</td>
                                                <td>{{ strtoupper($person->usertype) }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm edit-btn"
                                                            data-id="{{ $person->id }}"
                                                            data-staff_id="{{ $person->staff_id }}"
                                                            data-first_name="{{ $person->first_name }}"
                                                            data-last_name="{{ $person->last_name }}"
                                                            data-usertype="{{ $person->usertype }}">
                                                        Edit
                                                    </button>

                                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $person->id }}">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <div class="no-data-message">
                                                        <p>No staff data found.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="pagination-container">
                                    <p class="mb-0">
                                        Showing {{ $staff->firstItem() }} to {{ $staff->lastItem() }} of {{ $staff->total() }} results
                                    </p>

                                    <nav>
                                        <ul class="pagination custom-pagination">
                                            @if ($staff->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">&laquo; Previous</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $staff->appends(['search' => request()->search])->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                                                </li>
                                            @endif

                                            @for ($i = 1; $i <= $staff->lastPage(); $i++)
                                                <li class="page-item {{ $i == $staff->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $staff->appends(['search' => request()->search])->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor

                                            @if ($staff->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $staff->appends(['search' => request()->search])->nextPageUrl() }}" rel="next">Next &raquo;</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">Next &raquo;</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Initialize Feather Icons -->
                    <script>
                        feather.replace();
                    </script>

                    <!-- Modal for Adding Staff -->
                    <div id="customModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Add New Staff</h2>
                            <form action="{{ route('staff.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="staff_id" class="form-label">Staff ID</label>
                                    <input type="text" class="form-control" id="staff_id" name="staff_id"
       required placeholder="01-00011" pattern="\d{2}-\d{5}">
       
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function(){
        $('#staff_id').mask('00-00000');  // Enforce format 01-00011
    });
</script>

                                </div>
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="modern-btn btn-primary">Add New Staff</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Update Staff Modal -->
                    <div id="editModal" class="modal">
                        <div class="modal-content">
                            <span class="close" id="closeModal">&times;</span>
                            <h2>Edit Staff</h2>
                            <form id="editStaffForm" method="POST" action="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit_staff_id" name="id">
                                <div class="mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                                </div>
                               
                                <div class="modal-footer">
                                    <button type="submit" class="modern-btn btn-primary">Update Staff</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- JavaScript for Modal Management -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var modal = document.getElementById("customModal");
                            var openModalBtn = document.getElementById("openModal");
                            var closeModalBtn = document.querySelector("#customModal .close");

                            openModalBtn.addEventListener("click", function () {
                                modal.style.display = "flex";
                            });

                            closeModalBtn.addEventListener("click", function () {
                                modal.style.display = "none";
                            });

                            window.addEventListener("click", function (event) {
                                if (event.target === modal) {
                                    modal.style.display = "none";
                                }
                            });
                        });
                    </script>

                    <!-- JavaScript for Edit Modal -->
                   <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let staffId = this.dataset.id;  
            if (!staffId) {
                alert("Error: Staff ID is missing!");
                return;
            }

            document.getElementById("edit_staff_id").value = staffId;
            document.getElementById("editStaffForm").action = `/public/staff/update/${staffId}`;
            document.getElementById("edit_first_name").value = this.dataset.first_name;
            document.getElementById("edit_last_name").value = this.dataset.last_name;

            document.getElementById("editModal").style.display = "flex";
        });
    });

    document.getElementById("closeModal").addEventListener("click", function () {
        document.getElementById("editModal").style.display = "none";
    });

    window.addEventListener("click", function (event) {
        let modal = document.getElementById("editModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
</script>

                    <!-- JavaScript for Delete Functionality -->
                    <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            const dataId = this.dataset.id;
            const tableRow = this.closest("tr");

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
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ff4757, #ff3838); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                        🗑️
                    </div>
                    <h3 style="margin-bottom: 1rem; font-size: 1.6rem; background: linear-gradient(135deg, #ff4757, #ff6b7a); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Confirm Delete</h3>
                    <p style="margin-bottom: 2rem; font-size: 1.1rem; color: #ccc; line-height: 1.5;">
                        Are you sure you want to delete this staff member? 
                        <br><br>
                        <span style="color: #ff6b7a; font-weight: 600;">⚠️ This action cannot be undone!</span>
                    </p>
                </div>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <button id="cancelDelete" style="background: linear-gradient(135deg, #6c757d, #8a94a6); border: none; border-radius: 15px; padding: 12px 24px; color: white; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;">
                        <span>❌</span> Cancel
                    </button>
                    <button id="confirmDelete" style="background: linear-gradient(135deg, #ff4757, #ff3838); border: none; border-radius: 15px; padding: 12px 24px; color: white; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);">
                        <span>🗑️</span> Delete
                    </button>
                </div>
            `;

            confirmOverlay.appendChild(confirmBox);
            document.body.appendChild(confirmOverlay);

            const cancelBtn = confirmBox.querySelector("#cancelDelete");
            const confirmBtn = confirmBox.querySelector("#confirmDelete");

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

            cancelBtn.addEventListener("click", () => {
                confirmOverlay.remove();
            });

            confirmBtn.addEventListener("click", () => {
                confirmBtn.innerHTML = '<span>⏳</span> Deleting...';
                confirmBtn.disabled = true;
                cancelBtn.disabled = true;

                fetch(`/public/staff/${dataId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json",
                    }
                })
                .then(response => response.json())
                .then(data => {
                    confirmOverlay.remove();
                    if (data.success) {
                        tableRow.remove();
                        showModernAlert("✅ Success", "Staff deleted successfully!", "success");
                    } else {
                        showModernAlert("❌ Error", "Failed to delete staff: " + data.message, "error");
                    }
                })
                .catch(error => {
                    confirmOverlay.remove();
                    console.error("Error:", error);
                    showModernAlert("❌ Error", "Something went wrong.", "error");
                });
            });

            confirmOverlay.addEventListener('click', function(e) {
                if (e.target === confirmOverlay) {
                    confirmOverlay.remove();
                }
            });
        });
    });

    window.showModernAlert = function(title, message, type = 'success') {
        const alertBox = document.createElement('div');
        alertBox.className = `modern-alert ${type}`;
        alertBox.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #1e1e2f, #2a2a3e);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 1rem 1.5rem;
            color: white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            z-index: 10001;
            animation: slideInRight 0.3s ease-out;
            max-width: 400px;
        `;
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
});
</script>

                    <!-- JavaScript for Search Functionality -->
                    <script>
                        document.getElementById("searchInput").addEventListener("input", function () {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll("#dataTable tbody tr");

    rows.forEach(row => {
        let found = false;

       
        const searchableCells = row.querySelectorAll("td:not(:last-child)");

        searchableCells.forEach(cell => {
            // Skip if cell contains buttons or form elements
            if (cell.querySelector('button') || cell.querySelector('input') || cell.querySelector('select')) {
                return;
            }

            let originalText = cell.textContent || cell.innerText;
            let lowerText = originalText.toLowerCase();

            // Store original text if not already stored
            if (!cell.hasAttribute('data-original')) {
                cell.setAttribute('data-original', originalText);
            }

            // Check if search matches
            if (searchValue !== "" && lowerText.includes(searchValue)) {
                found = true;
                
                // Highlight matching text
                let regex = new RegExp(`(${searchValue})`, "gi");
                let highlightedText = originalText.replace(regex, `<span class="highlight">$1</span>`);
                cell.innerHTML = highlightedText;
            } else {
                // Restore original text if no match or search is empty
                if (cell.hasAttribute('data-original')) {
                    cell.textContent = cell.getAttribute('data-original');
                }
            }
        });

        // Show or hide row based on match
        row.style.display = (searchValue === "" || found) ? "" : "none";
    });
});
                    </script>

                    <!-- Print Table Script -->
                    <script>
                        document.getElementById("printTable").addEventListener("click", function() {
                            let printContent = document.getElementById("dataTable").outerHTML;
                            let newWindow = window.open("", "", "width=800,height=600");

                            newWindow.document.write(`
                                <html>
                                <head>
                                    <title>Staff Management Print</title>
                                    <style>
                                        body { font-family: Arial, sans-serif; }
                                        table { width: 100%; border-collapse: collapse; }
                                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                                        th { background-color: #4f46e5; color: white; }
                                        @media print {
                                            .no-print, .pagination { display: none !important; }
                                        }
                                    </style>
                                </head>
                                <body>
                                    <h2>Staff Management Report</h2>
                                    ${printContent}
                                </body>
                                </html>
                            `);

                            newWindow.document.close();
                            newWindow.print();
                        });
                    </script>

                    <!-- Download Table Script -->
                    <script>
                        document.getElementById("downloadBtn").addEventListener("click", function() {
                            const table = document.getElementById("dataTable");
                            const wb = XLSX.utils.table_to_book(table, {sheet: "Staff Data"});
                            XLSX.writeFile(wb, "staff_management.xlsx");
                        });
                    </script>

                    <style>
                        @keyframes fadeIn {
                            from { opacity: 0; }
                            to { opacity: 1; }
                        }

                        @keyframes slideInRight {
                            from {
                                opacity: 0;
                                transform: translateX(100%);
                            }
                            to {
                                opacity: 1;
                                transform: translateX(0);
                            }
                        }
                    </style>

                </div>
            </main>
              @include('staff.footer')
        </div>
    </div>

    @if(session('success'))
        <script>
            window.showModernAlert("✅ Success", "{{ session('success') }}", "success");
        </script>
    @endif
     @include('staff.js')

</body>

</html>
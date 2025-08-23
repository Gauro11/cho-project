<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('staff.css')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <style>
        /* ---------- Modern Base Styles ---------- */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            color: #1e1e2d;
        }

        h1,
        h2 {
            font-weight: 600;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            padding: 20px;
        }

        .input-group input {
            border-radius: 8px 0 0 8px;
            border: 1px solid #ced4da;
            outline: none;
        }

        .input-group-text {
            background-color: #f1f3f5;
            border: 1px solid #ced4da;
            border-right: 0;
        }

        /* Highlight search */
        .highlight {
            background-color: #fffa8b;
            font-weight: 600;
        }

        /* Modern buttons */
        .btn-primary {
            background: linear-gradient(135deg, #1e40af, #2563eb);
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
            color: white;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
        }

        .btn-warning {
            background: #f59e0b;
            border: none;
            border-radius: 6px;
            color: white;
            padding: 5px 12px;
            font-size: 0.85rem;
            cursor: pointer;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: #ef4444;
            border: none;
            border-radius: 6px;
            color: white;
            padding: 5px 12px;
            font-size: 0.85rem;
            cursor: pointer;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        /* Modern Pagination */
        .custom-pagination {
            display: flex;
            list-style: none;
            padding: 6px 12px;
            border-radius: 10px;
            background: #e2e8f0;
        }

        .custom-pagination .page-item {
            margin: 0 4px;
        }

        .custom-pagination .page-link {
            color: #1e40af;
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }

        .custom-pagination .page-item.active .page-link,
        .custom-pagination .page-link:hover {
            background-color: #1e40af;
            color: white;
        }

        .custom-pagination .disabled .page-link {
            color: #a1a1aa;
            pointer-events: none;
        }

        /* ---------- Modal Styles ---------- */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #ffffff;
            padding: 25px;
            width: 450px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .close {
            position: absolute;
            top: 12px;
            right: 15px;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
            color: #1e40af;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            gap: 10px;
        }

        /* Input rows */
        .input-row {
            display: flex;
            justify-content: space-between;
            gap: 4%;
        }

        .half-width {
            width: 48%;
        }

        /* Header Card Modern */
        .card-body.d-flex {
            background: linear-gradient(135deg, #1e40af, #2563eb);
            color: white;
            border-radius: 12px;
        }

        .card-body i {
            cursor: pointer;
            transition: 0.2s;
        }

        .card-body i:hover {
            color: #facc15;
        }

        .input-group input {
            background: #ffffff;
            color: #1e1e2d;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background-color: #1e40af;
            color: white;
            padding: 12px;
            text-align: left;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        table tr:hover {
            background-color: #f1f5f9;
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
                        <h1 class="h3">Staff Management</h1>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <i id="openModal" data-feather="plus"></i>
                                    <span>|</span>
                                    <div class="input-group">
                                        <span class="input-group-text"><i data-feather="search"></i></span>
                                        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                                    </div>
                                    <span>|</span>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <i data-feather="printer"></i>
                                    <i data-feather="download"></i>
                                    <span>|</span>
                                    <i data-feather="maximize-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Staff Table -->
                    <div class="col-12 col-lg-12 mt-4">
                        <div class="card p-0">
                            <table id="dataTable">
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
                                    @forelse($staff as $person)
                                    <tr>
                                        <td>{{ strtoupper($person->staff_id) }}</td>
                                        <td>{{ strtoupper($person->first_name) }}</td>
                                        <td>{{ strtoupper($person->last_name) }}</td>
                                        <td>{{ strtoupper($person->usertype) }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn"
                                                data-id="{{ $person->id }}"
                                                data-first_name="{{ $person->first_name }}"
                                                data-last_name="{{ $person->last_name }}"
                                                data-usertype="{{ $person->usertype }}">
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $person->id }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No data found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center p-3">
                                <p class="mb-0">
                                    Showing {{ $staff->firstItem() }} to {{ $staff->lastItem() }} of {{ $staff->total() }} results
                                </p>
                                <nav>
                                    <ul class="pagination custom-pagination">
                                        @if ($staff->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link">&laquo; Previous</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $staff->previousPageUrl() }}" rel="prev">&laquo; Previous</a></li>
                                        @endif

                                        @for ($i = 1; $i <= $staff->lastPage(); $i++)
                                            <li class="page-item {{ $i == $staff->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $staff->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        @if ($staff->hasMorePages())
                                            <li class="page-item"><a class="page-link" href="{{ $staff->nextPageUrl() }}" rel="next">Next &raquo;</a></li>
                                        @else
                                            <li class="page-item disabled"><span class="page-link">Next &raquo;</span></li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Modals (Add & Edit) -->
                    @include('staff.modals')

                </div>
            </main>
        </div>
    </div>

    <!-- Feather Icons -->
    <script>
        feather.replace();
    </script>

    <!-- Search Highlight JS -->
    <script>
        document.getElementById("searchInput").addEventListener("input", function () {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll("#dataTable tbody tr");

            rows.forEach(row => {
                let found = false;
                row.querySelectorAll("td").forEach(cell => {
                    let originalText = cell.innerText;
                    let lowerText = originalText.toLowerCase();

                    if (lowerText.includes(searchValue)) {
                        found = true;
                        let regex = new RegExp(`(${searchValue})`, "gi");
                        cell.innerHTML = originalText.replace(regex, `<span class="highlight">$1</span>`);
                    } else {
                        cell.innerHTML = originalText;
                    }
                });
                row.style.display = found ? "" : "none";
            });
        });
    </script>

    <!-- Modals & Delete JS (keep your existing scripts intact) -->
    @include('staff.scripts')

    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
</body>

</html>

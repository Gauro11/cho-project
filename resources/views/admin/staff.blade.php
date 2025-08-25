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

        h1, h2 {
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

        /* Table styles */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, #1e40af, #2563eb);
            color: white;
            border: none;
            padding: 12px;
        }

        .table tbody td {
            padding: 12px;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .btn-warning {
            background-color: #f59e0b;
            border: none;
            color: white;
        }

        .btn-danger {
            background-color: #ef4444;
            border: none;
            color: white;
        }

        .btn-sm {
            padding: 4px 12px;
            font-size: 0.875rem;
            border-radius: 6px;
            margin-right: 5px;
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

                    <!-- Staff Table - This was missing in your main document -->
                    <div class="row">
                        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                            <div class="card flex-fill" id="dataTable">
                                <table class="table table-hover my-0">
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
                                                <td colspan="5" class="text-center">No data found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-between align-items-center mt-3 px-3">
                                    <!-- Showing X to Y of Z results -->
                                    <p class="mb-0">
                                        Showing {{ $staff->firstItem() }} to {{ $staff->lastItem() }} of {{ $staff->total() }} results
                                    </p>

                                    <!-- Pagination Links -->
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
                                <input type="hidden" id="edit_staff_id" name="id">

                                <div class="mb-3">
                                    <label for="staff_id" class="form-label">Staff ID</label>
                                    <input type="text" class="form-control" id="staff_id" name="staff_id" required>
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
                                    <button type="submit" class="btn btn-primary">Add New Staff</button>
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
                                    <button type="submit" class="btn btn-primary">Update Staff</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- JavaScript for Modal Management -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var modal = document.getElementById("customModal");
                            var openModalBtn = document.getElementById("openModal");
                            var closeModalBtn = document.querySelector(".close");

                            // Open Modal
                            openModalBtn.addEventListener("click", function () {
                                modal.style.display = "flex";
                            });

                            // Close Modal
                            closeModalBtn.addEventListener("click", function () {
                                modal.style.display = "none";
                            });

                            // Close if clicked outside the modal
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
                            // Open Edit Modal
                            document.querySelectorAll(".edit-btn").forEach(button => {
                                button.addEventListener("click", function () {
                                    let staffId = this.dataset.id;  
                                    if (!staffId) {
                                        alert("Error: Staff ID is missing!");
                                        return;
                                    }

                                    // Set the hidden input field for ID
                                    document.getElementById("edit_staff_id").value = staffId;

                                    // Set the action URL correctly
                                    document.getElementById("editStaffForm").action = `/staff/update/${staffId}`;

                                    // Populate the form fields
                                    document.getElementById("edit_first_name").value = this.dataset.first_name;
                                    document.getElementById("edit_last_name").value = this.dataset.last_name;

                                    // Show the modal
                                    document.getElementById("editModal").style.display = "flex";
                                });
                            });

                            // Close button event listener
                            document.getElementById("closeModal").addEventListener("click", function () {
                                document.getElementById("editModal").style.display = "none";
                            });

                            // Close modal when clicking outside of it
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

                                    if (!confirm("Are you sure you want to delete this staff?")) return;

                                    fetch(`/staff/${dataId}`, {
                                        method: "DELETE",
                                        headers: {
                                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                            "Content-Type": "application/json"
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert("Staff deleted successfully!");
                                            location.reload();
                                        } else {
                                            alert("Failed to delete staff.");
                                        }
                                    })
                                    .catch(error => {
                                        console.error("Error:", error);
                                        alert("Something went wrong.");
                                    });
                                });
                            });
                        });
                    </script>

                    <!-- JavaScript for Search Functionality -->
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
                                        
                                        cell.innerHTML = originalText.replace(
                                            regex,
                                            `<span class="highlight" style="background-color: yellow; font-weight: bold;">$1</span>`
                                        );
                                    } else {
                                        cell.innerHTML = originalText;
                                    }
                                });

                                row.style.display = found ? "" : "none";
                            });
                        });
                    </script>

                </div>
            </main>
        </div>
    </div>

    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</body>

</html>
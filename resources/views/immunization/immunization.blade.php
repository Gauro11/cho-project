<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('staff.css')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

<style>
    :root {
        --primary-color: #1a202c;
        --primary-light: #2d3748;
        --secondary-color: #4a5568;
        --accent-color: #ed8936;
        --accent-light: #fbb040;
        --success-color: #38a169;
        --warning-color: #d69e2e;
        --danger-color: #e53e3e;
        --info-color: #3182ce;
        --white: #ffffff;
        --gray-50: #f9fafb;
        --gray-100: #f7fafc;
        --gray-200: #edf2f7;
        --gray-300: #e2e8f0;
        --gray-400: #cbd5e0;
        --gray-500: #a0aec0;
        --gray-600: #718096;
        --gray-700: #4a5568;
        --gray-800: #2d3748;
        --gray-900: #1a202c;
        --border-radius: 16px;
        --border-radius-sm: 8px;
        --border-radius-lg: 24px;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        transition: var(--transition);
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        line-height: 1.6;
    }

    .highlight {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-light));
        color: white;
        padding: 3px 8px;
        border-radius: 6px;
        font-weight: 600;
        box-shadow: var(--shadow-sm);
    }

    .custom-pagination {
        display: flex;
        list-style: none;
        padding: 0;
        border-radius: var(--border-radius);
        background: var(--white);
        padding: 6px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
    }

    .custom-pagination .page-item {
        margin: 0 2px;
    }

    .custom-pagination .page-link {
        color: var(--gray-600);
        padding: 8px 12px;
        border: none;
        border-radius: var(--border-radius-sm);
        transition: var(--transition);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .custom-pagination .page-item.active .page-link,
    .custom-pagination .page-link:hover {
        background: var(--primary-color);
        color: white;
        box-shadow: var(--shadow-sm);
    }

    .custom-pagination .disabled .page-link {
        color: var(--gray-400);
        pointer-events: none;
        opacity: 0.6;
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

    /* Clean Header Design */
    .page-header {
        background: var(--white);
        padding: 2.5rem 0;
        margin-bottom: 2rem;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-color), var(--accent-light));
    }

    .page-header h1 {
        color: var(--gray-900) !important;
        font-weight: 800;
        font-size: 2.25rem;
        margin: 0;
        letter-spacing: -0.025em;
    }

    .page-subtitle {
        color: var(--gray-600);
        font-size: 1.125rem;
        margin-top: 0.5rem;
        font-weight: 400;
    }

    /* Sleek Card Design */
    .card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-xl);
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .card-body {
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);
    }

    /* Modern Toolbar */
    .toolbar-left, .toolbar-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .toolbar-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 1rem;
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
    }

    .action-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: var(--border-radius-sm);
        background: var(--gray-100);
        border: 1px solid var(--gray-200);
        cursor: pointer;
        transition: var(--transition);
        color: var(--gray-600);
    }

    .action-button:hover {
        background: var(--gray-200);
        color: var(--gray-800);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .action-button.primary {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .action-button.primary:hover {
        background: var(--primary-light);
        border-color: var(--primary-light);
    }

    .action-button.accent {
        background: var(--accent-color);
        color: white;
        border-color: var(--accent-color);
    }

    .action-button.accent:hover {
        background: var(--accent-light);
        border-color: var(--accent-light);
    }

    /* Enhanced Search */
    .search-container {
        position: relative;
        min-width: 320px;
    }

    .search-container .input-group {
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
    }

    .search-container .input-group:focus-within {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgb(237 137 54 / 0.1);
    }

    .search-container .input-group-text {
        background: transparent;
        border: none;
        color: var(--gray-500);
        padding: 0.875rem 1rem;
    }

    .search-container .form-control {
        border: none;
        background: transparent;
        color: var(--gray-900);
        font-weight: 500;
        padding: 0.875rem 1rem;
        font-size: 0.9rem;
    }

    .search-container .form-control:focus {
        box-shadow: none;
        outline: none;
    }

    .search-container .form-control::placeholder {
        color: var(--gray-500);
        font-weight: 400;
    }

    /* Refined Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(26, 32, 44, 0.75);
        backdrop-filter: blur(12px);
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal.show {
        opacity: 1;
    }

    .modal-content {
        background: var(--white);
        padding: 2.5rem;
        width: 480px;
        max-width: 90vw;
        border-radius: var(--border-radius-lg);
        position: relative;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--gray-200);
        transform: scale(0.95) translateY(-20px);
        transition: transform 0.3s ease;
    }

    .modal.show .modal-content {
        transform: scale(1) translateY(0);
    }

    .modal-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-color), var(--accent-light));
        border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
    }

    .modal-content h2 {
        color: var(--gray-900);
        font-weight: 700;
        margin-bottom: 2rem;
        font-size: 1.5rem;
        letter-spacing: -0.025em;
    }

    .close {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--gray-100);
        color: var(--gray-600);
        border: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 16px;
        transition: var(--transition);
    }

    .close:hover {
        background: var(--danger-color);
        color: white;
        border-color: var(--danger-color);
        transform: scale(1.05);
    }

    /* Clean Form Design */
    .form-label {
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.75rem;
        font-size: 0.875rem;
        display: block;
    }

    .form-control {
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius-sm);
        padding: 0.875rem 1rem;
        font-weight: 500;
        transition: var(--transition);
        background: var(--gray-50);
        width: 100%;
        font-size: 0.9rem;
        color: var(--gray-900);
    }

    .form-control:focus {
        border-color: var(--accent-color);
        background: var(--white);
        box-shadow: 0 0 0 3px rgb(237 137 54 / 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: var(--gray-500);
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 2rem;
        gap: 1rem;
    }

    /* Sophisticated Buttons */
    .btn {
        border-radius: var(--border-radius-sm);
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: var(--transition);
        border: 1px solid transparent;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.4s ease;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background: var(--primary-light);
        border-color: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-secondary {
        background: var(--gray-100);
        color: var(--gray-700);
        border-color: var(--gray-200);
    }

    .btn-secondary:hover {
        background: var(--gray-200);
        color: var(--gray-800);
    }

    .btn-success {
        background: var(--success-color);
        color: white;
        border-color: var(--success-color);
    }

    .btn-warning {
        background: var(--warning-color);
        color: white;
        border-color: var(--warning-color);
    }

    .btn-danger {
        background: var(--danger-color);
        color: white;
        border-color: var(--danger-color);
    }

    /* Badge System */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-primary {
        background: rgba(26, 32, 44, 0.1);
        color: var(--primary-color);
    }

    .badge-success {
        background: rgba(56, 161, 105, 0.1);
        color: var(--success-color);
    }

    .badge-warning {
        background: rgba(214, 158, 46, 0.1);
        color: var(--warning-color);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card-body {
            flex-direction: column;
            align-items: stretch;
            gap: 1.5rem;
        }
        
        .toolbar-left, .toolbar-right {
            justify-content: center;
        }
        
        .search-container {
            min-width: 100%;
        }
        
        .modal-content {
            width: 95vw;
            padding: 2rem;
        }
        
        .page-header h1 {
            font-size: 1.875rem;
        }

        .toolbar-group {
            flex-wrap: wrap;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .page-header {
            padding: 2rem 1rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .modal-content {
            padding: 1.5rem;
        }
    }

    /* Smooth Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.6s ease-out;
    }

    .page-header {
        animation: fadeInUp 0.4s ease-out;
    }

    /* Loading State */
    .btn.loading {
        pointer-events: none;
        opacity: 0.7;
        position: relative;
    }

    .btn.loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Focus styles for accessibility */
    .action-button:focus,
    .btn:focus,
    .form-control:focus {
        outline: 2px solid var(--accent-color);
        outline-offset: 2px;
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

                    <div class="page-header">
                        <div class="container-fluid">
                            <h1>Staff Management</h1>
                            <p class="page-subtitle">Manage your team members and their information</p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Left Toolbar -->
                                <div class="toolbar-left">
                                    <div class="toolbar-group">
                                        <div class="action-button primary" id="openModal" title="Add New Staff">
                                            <i data-feather="plus" size="18"></i>
                                        </div>
                                    </div>

                                    <div class="search-container">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i data-feather="search" size="18"></i>
                                            </span>
                                            <input type="text" id="searchInput" name="search" class="form-control"
                                                placeholder="Search staff members...">
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Toolbar -->
                                <div class="toolbar-right">
                                    <div class="toolbar-group">
                                        <div class="action-button" title="Print Report">
                                            <i data-feather="printer" size="18"></i>
                                        </div>
                                        <div class="action-button" title="Export Data">
                                            <i data-feather="download" size="18"></i>
                                        </div>
                                        <div class="action-button" title="Full Screen">
                                            <i data-feather="maximize-2" size="18"></i>
                                        </div>
                                    </div>
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
                            <button class="close" type="button">&times;</button>
                            <h2>Add New Staff Member</h2>
                            <form action="{{ route('staff.store') }}" method="POST">
                                @csrf
                                <input type="hidden" id="edit_staff_id" name="id">

                                <div class="mb-3">
                                    <label for="staff_id" class="form-label">Staff ID</label>
                                    <input type="text" class="form-control" id="staff_id" name="staff_id" 
                                           placeholder="Enter staff ID" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" 
                                           placeholder="Enter first name" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" 
                                           placeholder="Enter last name" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i data-feather="plus" size="16"></i>
                                        Add Staff Member
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Update Staff Modal -->
                    <div id="editModal" class="modal">
                        <div class="modal-content">
                            <button class="close" id="closeModal" type="button">&times;</button>
                            <h2>Edit Staff Member</h2>
                            <form id="editStaffForm" method="POST" action="">
                            @csrf
                                @method('PUT')
                                <input type="hidden" id="edit_staff_id" name="id">
                                
                                <div class="mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="edit_first_name" name="first_name" 
                                           placeholder="Enter first name" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="edit_last_name" name="last_name" 
                                           placeholder="Enter last name" required>
                                </div>
                               
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i data-feather="save" size="16"></i>
                                        Update Staff
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var modal = document.getElementById("customModal");
                            var openModalBtn = document.getElementById("openModal");
                            var closeModalBtns = document.querySelectorAll(".close, .close-modal");

                            // Open Modal with smooth animation
                            openModalBtn.addEventListener("click", function () {
                                modal.style.display = "flex";
                                setTimeout(() => modal.classList.add("show"), 10);
                            });

                            // Close Modal with smooth animation
                            closeModalBtns.forEach(btn => {
                                btn.addEventListener("click", function () {
                                    modal.classList.remove("show");
                                    setTimeout(() => modal.style.display = "none", 300);
                                });
                            });

                            // Close if clicked outside the modal
                            window.addEventListener("click", function (event) {
                                if (event.target === modal) {
                                    modal.classList.remove("show");
                                    setTimeout(() => modal.style.display = "none", 300);
                                }
                            });
                        });
                    </script>

               <script>
document.addEventListener("DOMContentLoaded", function () {
    // Open Modal
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let staffId = this.dataset.id;  
            if (!staffId) {
                alert("Error: Staff ID is missing!");
                return;
            }

            // ✅ Set the hidden input field for ID
            document.getElementById("edit_staff_id").value = staffId;

            // ✅ Set the action URL correctly
            document.getElementById("editStaffForm").action = `/staff/update/${staffId}`;

            // ✅ Populate the form fields
            document.getElementById("edit_first_name").value = this.dataset.first_name;
            document.getElementById("edit_last_name").value = this.dataset.last_name;

            // ✅ Properly set selected value in dropdown
            let positionDropdown = document.getElementById("edit_position");
            let usertype = this.dataset.usertype;
            for (let option of positionDropdown.options) {
                if (option.value === usertype) {
                    option.selected = true;
                    break;
                }
            }

            // ✅ Show the modal with animation
            let editModal = document.getElementById("editModal");
            editModal.style.display = "flex";
            setTimeout(() => editModal.classList.add("show"), 10);
        });
    });

    // ✅ Close button event listener
    document.querySelectorAll("#editModal .close, #editModal .close-modal").forEach(btn => {
        btn.addEventListener("click", function () {
            let editModal = document.getElementById("editModal");
            editModal.classList.remove("show");
            setTimeout(() => editModal.style.display = "none", 300);
        });
    });

    // ✅ Close modal when clicking outside of it
    window.addEventListener("click", function (event) {
        let modal = document.getElementById("editModal");
        if (event.target === modal) {
            modal.classList.remove("show");
            setTimeout(() => modal.style.display = "none", 300);
        }
    });
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-button").forEach(button => {
            button.addEventListener("click", function () {
                const dataId = this.dataset.id;

                if (confirm("Are you sure you want to delete this data?")) {
                    fetch(`/staff/delete/${dataId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Content-Type": "application/json"
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("Data deleted successfully!");
                                location.reload();
                            } else {
                                alert("Failed to delete data.");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Something went wrong.");
                        });

                }
            });
        });
    });
</script>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById("searchInput").addEventListener("input", function () {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll("#dataTable tbody tr");

    rows.forEach(row => {
        let found = false;

        row.querySelectorAll("td").forEach(cell => {
            let originalText = cell.innerText; // Store original uppercase text
            let lowerText = originalText.toLowerCase();

            if (lowerText.includes(searchValue)) {
                found = true;
                let regex = new RegExp(`(${searchValue})`, "gi");
                
                // Replace only the matching part, but keep original case
                cell.innerHTML = originalText.replace(
                    regex,
                    `<span class="highlight" style="background-color: yellow; font-weight: bold;">$1</span>`
                );
            } else {
                cell.innerHTML = originalText; // Reset text without modification
            }
        });

        // Show or hide row based on search match
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('staff.css')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

<style>
    :root {
        --primary-color: #667eea;
        --primary-dark: #5a67d8;
        --secondary-color: #764ba2;
        --accent-color: #f093fb;
        --success-color: #48bb78;
        --warning-color: #ed8936;
        --danger-color: #f56565;
        --dark-color: #2d3748;
        --light-gray: #f7fafc;
        --border-color: #e2e8f0;
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-accent: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    * {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .highlight {
        background: var(--gradient-accent);
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
    }

    .custom-pagination {
        display: flex;
        list-style: none;
        padding: 0;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 8px 12px;
        box-shadow: var(--shadow-sm);
    }

    .custom-pagination .page-item {
        margin: 0 3px;
    }

    .custom-pagination .page-link {
        color: var(--primary-color);
        padding: 10px 14px;
        border: 2px solid transparent;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        font-weight: 500;
        background: rgba(255, 255, 255, 0.7);
    }

    .custom-pagination .page-item.active .page-link,
    .custom-pagination .page-link:hover {
        background: var(--gradient-primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .custom-pagination .disabled .page-link {
        color: var(--text-secondary);
        pointer-events: none;
        opacity: 0.5;
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

    /* Modern Page Header */
    .page-header {
        background: var(--gradient-primary);
        padding: 2rem 0;
        margin: -1rem -1rem 2rem -1rem;
        border-radius: 0 0 24px 24px;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="4"/></g></svg>');
        opacity: 0.3;
    }

    .page-header h1 {
        color: white !important;
        font-weight: 700;
        font-size: 2.5rem;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    /* Modern Card Design */
    .card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: var(--shadow-xl);
        overflow: hidden;
        position: relative;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }

    .card-body {
        padding: 2rem;
        background: var(--gradient-primary);
        position: relative;
    }

    /* Modern Toolbar */
    .toolbar-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .toolbar-divider {
        width: 2px;
        height: 30px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
    }

    .icon-button {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .icon-button:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .icon-button i {
        color: white !important;
    }

    /* Modern Search Input */
    .modern-search {
        position: relative;
        min-width: 300px;
    }

    .modern-search .input-group {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .modern-search .input-group:focus-within {
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: var(--shadow-md);
    }

    .modern-search .input-group-text {
        background: transparent;
        border: none;
        color: var(--text-secondary);
        padding: 0.75rem 1rem;
    }

    .modern-search .form-control {
        border: none;
        background: transparent;
        color: var(--text-primary);
        font-weight: 500;
        padding: 0.75rem 1rem;
    }

    .modern-search .form-control:focus {
        box-shadow: none;
        background: transparent;
    }

    .modern-search .form-control::placeholder {
        color: var(--text-secondary);
        font-weight: 400;
    }

    /* Modal Updates */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { 
            opacity: 0;
            transform: translateY(-50px) scale(0.9);
        }
        to { 
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-content {
        background: white;
        padding: 2rem;
        width: 500px;
        max-width: 90vw;
        border-radius: 24px;
        text-align: left;
        position: relative;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideIn 0.3s ease;
    }

    .modal-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: var(--gradient-primary);
        border-radius: 24px 24px 0 0;
    }

    .modal-content h2 {
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
    }

    .close {
        position: absolute;
        top: 1rem;
        right: 1.5rem;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(248, 113, 113, 0.1);
        color: var(--danger-color);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .close:hover {
        background: var(--danger-color);
        color: white;
        transform: scale(1.1);
    }

    /* Modern Form Elements */
    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        background: rgba(247, 250, 252, 0.5);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
        transform: translateY(-1px);
    }

    .modal-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
        gap: 1rem;
    }

    /* Modern Buttons */
    .btn {
        border-radius: 12px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: none;
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
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: var(--gradient-primary);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-success {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #f56565, #e53e3e);
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .toolbar-section {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .modern-search {
            min-width: 250px;
            order: 3;
            width: 100%;
        }
        
        .modal-content {
            width: 95vw;
            padding: 1.5rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .page-header h1 {
            font-size: 2rem;
        }
    }

    /* Animation for icons */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .icon-button:hover i {
        animation: pulse 0.6s ease-in-out;
    }

    /* Loading states */
    .btn.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .btn.loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        margin: auto;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
                            <h1 class="h3 mb-0">Staff Management</h1>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="toolbar-section">
                                    <!-- Add Staff Button -->
                                    <div class="icon-button" id="openModal" title="Add New Staff">
                                        <i data-feather="plus"></i>
                                    </div>

                                    <div class="toolbar-divider"></div>

                                    <!-- Search Field -->
                                    <div class="modern-search">
                                        <div class="input-group">
                                            <span class="input-group-text"><i data-feather="search"></i></span>
                                            <input type="text" id="searchInput" name="search" class="form-control"
                                                placeholder="Search staff members...">
                                        </div>
                                    </div>

                                    <div class="toolbar-divider"></div>
                                </div>

                                <!-- Action Buttons on the Right -->
                                <div class="toolbar-section">
                                    <!-- Print Button -->
                                    <div class="icon-button" title="Print">
                                        <i data-feather="printer"></i>
                                    </div>

                                    <!-- Download Button -->
                                    <div class="icon-button" title="Download">
                                        <i data-feather="download"></i>
                                    </div>

                                    <div class="toolbar-divider"></div>

                                    <!-- Expand Button -->
                                    <div class="icon-button" title="Full Screen">
                                        <i data-feather="maximize-2"></i>
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
                            <span class="close">&times;</span>
                            <h2>Add New Staff Member</h2>
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
                                    <button type="submit" class="btn btn-primary">Add Staff Member</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Update Staff Modal -->
                    <div id="editModal" class="modal">
                        <div class="modal-content">
                            <span class="close" id="closeModal">&times;</span>
                            <h2>Edit Staff Member</h2>
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

            // ✅ Show the modal
            document.getElementById("editModal").style.display = "flex";
        });
    });

    // ✅ Close button event listener
    document.getElementById("closeModal").addEventListener("click", function () {
        document.getElementById("editModal").style.display = "none";
    });

    // ✅ Close modal when clicking outside of it
    window.addEventListener("click", function (event) {
        let modal = document.getElementById("editModal");
        if (event.target === modal) {
            modal.style.display = "none";
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
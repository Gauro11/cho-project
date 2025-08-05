<!DOCTYPE html>
<html lang="en">

<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
	@include('staff.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            border-radius: 20px;
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
             background: var(--primary-gradient);
            border: none;
            color: var(--text-primary);
        }

        /* Modern Dropdown */
        .modern-dropdown .dropdown-menu {
            background: var(--primary-gradient);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            box-shadow: var(--shadow-glow);
            padding: 1rem;
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
            .no-print, .pagination {
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
                                        <span class="input-group-text bg-transparent"><i data-feather="search"></i></span>
                                        <input type="text" id="searchInput" name="search" class="form-control modern-form-control"
                                            placeholder="Search records..." style="border-left: none;">
                                    </div>

                                    <span class="separator">|</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <div class="dropdown modern-dropdown">
                                        <button class="modern-btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i data-feather="upload"></i> Import
                                        </button>
                                        <div class="dropdown-menu p-3" style="min-width: 250px;">
                                            <form action="{{ route('immunization.import') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="file" name="file" class="modern-form-control form-control-sm mb-2" required>
                                                <button type="submit" class="modern-btn btn-success w-100">📤 Upload</button>
                                            </form>
                                        </div>
                                    </div>

                                    <button id="printTable" class="modern-btn btn-primary btn-sm">
                                        <i data-feather="printer"></i> Print
                                    </button>

                                    <a href="{{ route('immunization.export') }}" class="modern-btn btn-success btn-sm">
                                        <i data-feather="download"></i> Download 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('immunization.immunization_table')

                    <!-- Initialize Feather Icons -->
                    <script>
                        feather.replace();
                    </script>

                    <!-- Modern Modal Structure -->
                    <div id="customModal" class="modern-modal modal">
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
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            setTimeout(() => {
                                var modal = document.getElementById("customModal");
                                var openModalBtn = document.getElementById("openModal");
                                var closeModalBtn = document.querySelector(".close");

                                if (!modal || !openModalBtn) {
                                    console.error("Modal or button not found!");
                                    return;
                                }

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
                            }, 100);
                        });
                    </script>

                    <script>
                        // Prevent selection of past dates
                        document.addEventListener("DOMContentLoaded", function () {
                            let today = new Date().toISOString().split("T")[0];
                            document.getElementById("date").setAttribute("min", today);
                        });
                    </script>

                    <script>
                        document.getElementById("printTable").addEventListener("click", function () {
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
                        document.addEventListener("DOMContentLoaded", function () {
                            document.querySelectorAll(".delete-button").forEach(button => {
                                button.addEventListener("click", function () {
                                    const dataId = this.dataset.id;

                                    if (confirm("Are you sure you want to delete this data?")) {
                                        fetch(`/immunization/delete/${dataId}`, {
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

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        document.getElementById("searchInput").addEventListener("input", function () {
                            let searchValue = this.value.toLowerCase();
                            let rows = document.querySelectorAll("#dataTable tbody tr");

                            rows.forEach(row => {
                                let cell = row.querySelector("td");
                                let text = cell.innerText;
                                let lowerText = text.toLowerCase();

                                if (searchValue === "" || lowerText.includes(searchValue)) {
                                    row.style.display = "";
                                    cell.innerHTML = text;

                                    // Apply highlighting
                                    if (searchValue !== "") {
                                        let regex = new RegExp(`(${searchValue})`, "gi");
                                        cell.innerHTML = text.replace(regex, `<span class="highlight">$1</span>`);
                                    }
                                } else {
                                    row.style.display = "none";
                                }
                            });
                        });
                    </script>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            document.querySelectorAll(".delete-button").forEach(button => {
                                button.addEventListener("click", function () {
                                    let dataId = this.dataset.id;

                                    if (confirm("Are you sure you want to delete this data?")) {
                                        fetch(`/data/${dataId}`, {
                                            method: "DELETE",
                                            headers: {
                                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                                            }
                                        }).then(response => {
                                            if (response.ok) {
                                                alert("Data deleted successfully!");
                                                location.reload();
                                            } else {
                                                alert("Error deleting data.");
                                            }
                                        });
                                    }
                                });
                            });
                        });
                    </script>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const editModal = document.getElementById("editModal");
                            const closeEditModalBtn = document.querySelector("#editModal .close");
                            const cancelEditModalBtn = document.getElementById("cancelEditModal");

                            // Open modal and populate form
                            document.querySelectorAll(".edit-button").forEach(button => {
                                button.addEventListener("click", function () {
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
                            document.getElementById("updateForm").addEventListener("submit", function (event) {
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
                                        alert("Record updated successfully!");
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
                </div>
            </main>

			@include('staff.footer')
		</div>
	</div>

@include('staff.js')

</body>

</html>
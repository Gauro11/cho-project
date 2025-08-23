<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('staff.css')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

<style>
            .highlight {
        background-color: yellow;
        font-weight: bold;
    }
.custom-pagination {
    display: flex;
    list-style: none;
    padding: 0;
    border-radius: 5px;
    background: #f8f9fa;
    padding: 8px 12px;
}

.custom-pagination .page-item {
    margin: 0 5px;
}

.custom-pagination .page-link {
    color: #000957;
    padding: 8px 12px;
    border: 1px solid #000957;
    border-radius: 5px;
    transition: 0.3s;
    text-decoration: none;
}

.custom-pagination .page-item.active .page-link,
.custom-pagination .page-link:hover {
    background-color: #000957;
    color: white;
}

.custom-pagination .disabled .page-link {
    color: #ccc;
    pointer-events: none;
    border: 1px solid #ccc;
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

        /* Modal Background */
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

        /* Modal Content */
        .modal-content {
            background-color: white;
            padding: 20px;
            width: 400px;
            border-radius: 10px;
            text-align: left;
            position: relative;
            border: 2px solid blue;
        }

        /* Close Button */
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }

        /* Modal Footer */
        .modal-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
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
                        <h1 style="color:#000957;" class="h3 mb-3">Staff Management</h1>
                        
                    </div>

                    <br><br>
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <!-- Settings Icon (White Color) -->
                                    <i id="openModal" data-feather="plus" style="color: white; cursor: pointer;"></i>

                                    <!-- Vertical Bar Separator -->
                                    <span style="color: white; font-weight: bold;">|</span>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i data-feather="search"></i></span>
                                        <input type="text" id="searchInput" name="search" class="form-control"
                                            placeholder="Search..." style="background-color: white; color: black;">
                                    </div>

                                    <span style="color: white; font-weight: bold;">|</span>

                                    <!-- Search Field with Icon (Next to the Separator) -->
                                    
                                </div>

                                <!-- Pagination + Download Icon on the Right -->
                                <div class="d-flex align-items-center gap-2">
                                    <!-- Pagination (Smaller Size) -->

                                    <!-- Download Icon -->
                                    <i data-feather="printer" style="color: white;"></i>
                                    <i data-feather="download" style="color: white;"></i>


                                    <span style="color: white; font-weight: bold;">|</span>

                                    <i data-feather="maximize-2" style="color: white;"></i>

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

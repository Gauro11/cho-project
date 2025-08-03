<!DOCTYPE html>
<html lang="en">

<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
	@include('staff.css')

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
                        <h1 style="color:#000957;" class="h3 mb-3">Immunization Records</h1>
                        <div class="d-flex gap-2" style="width: 100%; max-width: 400px;">

                        </div>
                    </div>

                    <br><br>

                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <!-- Settings Icon (White Color) -->
                                    <!-- <i id="openModal" data-feather="plus" style="color: white; cursor: pointer;"></i> -->
                                    <button class="btn btn-success btn-sm" id="openModal" >
                                        Add New Record
                                    </button>
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

                                    <!-- Import Excel Dropdown -->
<div class="dropdown">
    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i data-feather="upload" style="color: white;"></i> Import
    </button>
    <div class="dropdown-menu p-3" style="min-width: 250px;">
        <form action="{{ route('immunization.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="form-control form-control-sm mb-2" required>
            <button type="submit" class="btn btn-sm btn-success w-100">Upload</button>
        </form>
    </div>
</div>


                                <button id="printTable" class="btn btn-primary btn-sm">
                                    <i data-feather="printer" style="color: white;"></i> Print
                                </button>

                                    <!-- Download Icon -->
                                    <a href="{{ route('immunization.export') }}" class="btn btn-success btn-sm">
    <i data-feather="download" style="color: white;"></i> Download 
</a>



                                    <!-- <span style="color: white; font-weight: bold;">|</span> -->

                                    <!-- <i data-feather="maximize-2" style="color: white;"></i> -->

                                </div>
                            </div>
                        </div>
                    </div>

                    @include('immunization.immunization_table')



                    <!-- Initialize Feather Icons -->
                    <script>
                        feather.replace();
                    </script>

                    

                    <!-- Modal Structure -->
                    <div id="customModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Add Immunization Record</h2>
                            <form action="{{ route('immunization.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
    <label for="date" class="form-label">Date of Immunization</label>
    <input type="date" class="form-control" id="date" name="date" required min="">
</div>

<div class="mb-3">
    <label for="vaccine_name" class="form-label">Vaccine Name</label>
    <input type="text" class="form-control text-uppercase" id="vaccine_name" name="vaccine_name" required oninput="this.value = this.value.toUpperCase()">
</div>

                                <div class="mb-3">
                                    <label for="male_vaccinated" class="form-label">Male Vaccinated</label>
                                    <input type="number" class="form-control" id="male_vaccinated" name="male_vaccinated" required min="0">
                                </div>

                                <div class="mb-3">
                                    <label for="female_vaccinated" class="form-label">Female Vaccinated</label>
                                    <input type="number" class="form-control" id="female_vaccinated" name="female_vaccinated" required min="0">
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Add Immunization Record</button>
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
        }, 100); // Delay to ensure icons are loaded
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



<div id="editModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Immunization Data</h2>
        <form id="updateForm" action="{{ route('immunization.update') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id" name="id">

            <div class="mb-3">
                <label for="edit_vaccine" class="form-label">Vaccine Name</label>
                <input type="text" class="form-control" id="edit_vaccine" name="vaccine_name" required>
            </div>

            <div class="mb-3">
                <label for="edit_date" class="form-label">Date</label>
                <input type="date" class="form-control" id="edit_date" name="date" required>
            </div>

            <div class="mb-3">
                <label for="edit_male" class="form-label">Male Vaccinated</label>
                <input type="number" class="form-control" id="edit_male" name="male_vaccinated" required>
            </div>

            <div class="mb-3">
                <label for="edit_female" class="form-label">Female Vaccinated</label>
                <input type="number" class="form-control" id="edit_female" name="female_vaccinated" required>
            </div>

            <div class="modal-footer">
                <button type="button" id="cancelEditModal" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>




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
                                        fetch(/data/${ dataId }, {
                                            method: "DELETE",
                                            headers: {
                                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                                            }
                                        }).then(response => {
                                            if (response.ok) {
                                                alert("Data deleted successfully!");
                                                location.reload(); // Refresh the page
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


                   
                </div>
            </main>

			@include('staff.footer')
		</div>
	</div>

@include('staff.js')

</body>

</html>
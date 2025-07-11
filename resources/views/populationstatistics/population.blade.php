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
                        <h1 style="color:#000957;" class="h3 mb-3">Population Records</h1>
                        <div class="d-flex gap-2" style="width: 100%; max-width: 400px;">

                            
                        </div>
                    </div>

                    <br><br>

                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <!-- Settings Icon (White Color) -->
                                    <button class="btn btn-success btn-sm" id="openModal">
                                        Add New Record
                                    </button>
                                    <!-- <i id="openModal" data-feather="plus" style="color: white; cursor: pointer;"></i> -->

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

                                    
                                    <button id="printTable" class="btn btn-primary btn-sm">
                                        <i data-feather="printer" style="color: white;"></i> Print
                                    </button>


                                    <!-- Download Icon -->
                                    <button id="downloadCSV" class="btn btn-primary btn-sm">
    <i data-feather="download" style="color: white;"></i> Download
</button>

                                    <!-- <span style="color: white; font-weight: bold;">|</span>

                                    <i data-feather="maximize-2" style="color: white;"></i> -->

                                </div>
                            </div>
                        </div>
                    </div>


                    @include('populationstatistics.population_table')

                    <!-- Initialize Feather Icons -->
                    <script>
                        feather.replace();
                    </script>

                    

                    <!-- Modal Structure -->
                    <div id="customModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Add Population Records</h2>
                            <form action="{{ route('population.store') }}" method="POST">
    @csrf

    <!-- Barangay Dropdown -->
    <div class="mb-3">
        <label for="location" class="form-label">Location (Barangay)</label>
        <select class="form-control" id="location" name="location" required>
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
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" id="date" name="date" required>
    </div>

    <!-- Total Population -->
    <div class="mb-3">
        <label for="population" class="form-label">Total Population</label>
        <input type="number" class="form-control" id="population" name="population" required>
    </div>

    <!-- Submit Button -->
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add Record</button>
    </div>
</form>



                        </div>
                    </div>



<div id="editModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Population</h2>
        <form id="updateForm" action="{{ route('population.update') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id" name="id">

            <!-- Barangay Dropdown (Location) -->
            <div class="mb-3">
                <label for="edit_location" class="form-label">Location (Barangay)</label>
                <select class="form-control" id="edit_location" name="location" required>
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
                <label for="edit_year" class="form-label">Date</label>
                <input type="date" class="form-control" id="edit_year" name="year" required>
            </div>

            <!-- Total Population -->
            <div class="mb-3">
                <label for="edit_population" class="form-label">Total Population</label>
                <input type="number" class="form-control" id="edit_population" name="total_population" required>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update Population Records</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById("downloadCSV").addEventListener("click", function () {
        window.location.href = "{{ route('download.csv') }}";
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
        document.getElementById("date").setAttribute("min", today);
    });
</script> 





                    <!-- Initialize Feather Icons -->
                    <script>
                        feather.replace();
                    </script>


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
    document.getElementById("updateForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(this);
    formData.append('_method', 'PUT'); // Laravel requires this to spoof PUT method

    fetch(`/population/update`, {
        method: "POST", // Keep it POST for FormData
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

</script>




<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-button").forEach(button => {
        button.addEventListener("click", function () {
            const dataId = this.dataset.id;

            if (confirm("Are you sure you want to delete this data?")) {
                fetch(`/population/delete/${dataId}`, {
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

        // Show and populate modal
        document.querySelectorAll(".edit-button").forEach(button => {
            button.addEventListener("click", function () {
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
        closeEditModalBtn.addEventListener("click", function () {
            editModal.style.display = "none";
        });

        cancelEditModalBtn.addEventListener("click", function () {
            editModal.style.display = "none";
        });

        // Close modal if clicked outside the modal content
        window.addEventListener("click", function (event) {
            if (event.target === editModal) {
                editModal.style.display = "none";
            }
        });
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

                </div>
            </main>

			@include('staff.footer')
		</div>
	</div>

@include('staff.js')

</body>

</html>
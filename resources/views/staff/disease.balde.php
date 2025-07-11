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
                        <h1 style="color:#000957;" class="h3 mb-3">Records</h1>
                        <div class="d-flex gap-2" style="width: 100%; max-width: 400px;">

                            <button id="openModal" class="w-50 mb-3"
                                style="background-color: #000957; color: white;">Add</button>
                        </div>
                    </div>

                    <br><br>

                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <!-- Settings Icon (White Color) -->
                                    <i data-feather="settings" style="color: white;"></i>

                                    <!-- Vertical Bar Separator -->
                                    <span style="color: white; font-weight: bold;">|</span>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i data-feather="search"></i></span>
                                        <input type="text" id="searchInput" name="search" class="form-control"
                                            placeholder="Search..." style="background-color: white; color: black;">
                                    </div>

                                    <span style="color: white; font-weight: bold;">|</span>


                                    <!-- Search Field with Icon (Next to the Separator) -->
                                    <form method="GET" action="{{ route('data.index') }}">
                                        <select name="category_id" class="form-select" onchange="this.form.submit()">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $selectedCategory==$category->id ?
                                                'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </form>

                                    <!-- Search Field -->




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




                    @if($data->isNotEmpty())
                    <div class="row">
                        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                            <div class="card flex-fill" id="dataTable">
                                <table class="table table-hover my-0">
                                    <thead>
                                        <tr style="color: white;">
                                            <th>CASES</th>
                                            <th>MALE COUNT</th>
                                            <th>FEMALE COUNT</th>
                                            <th>DATE</th>
                                            <th>TOTAL</th>
                                            <th>PERCENTAGE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background-color: white;">
                                        @foreach($data as $row)
                                        <tr>
                                            <td>{{ $row->case_name }}</td>
                                            <td>{{ $row->male_count }}</td>
                                            <td>{{ $row->female_count }}</td>
                                            <td>{{ $row->date }}</td>
                                            <td>{{ $row->male_count + $row->female_count }}</td>
                                            <td>{{ $row->percentage }}%</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm edit-button"
                                                    data-id="{{ $row->id }}" data-date="{{ $row->date }}"
                                                    data-case_name="{{ $row->case_name }}"
                                                    data-male_count="{{ $row->male_count }}"
                                                    data-female_count="{{ $row->female_count }}"
                                                    data-percentage="{{ $row->percentage }}">

                                                    Edit
                                                </button>

                                                <form action="{{ route('data.destroy', $row->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <!-- Showing X to Y of Z results -->
                                    <p class="mb-0">
                                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total()
                                        }} results
                                    </p>

                                    <!-- Pagination Links -->
                                    <nav>
                                        <ul class="pagination custom-pagination">
                                            @if ($data->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">&laquo; Previous</span>
                                            </li>
                                            @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $data->appends(['search' => request()->search])->previousPageUrl() }}"
                                                    rel="prev">&laquo; Previous</a>
                                            </li>
                                            @endif

                                            @for ($i = 1; $i <= $data->lastPage(); $i++)
                                                <li class="page-item {{ $i == $data->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $data->appends(['search' => request()->search])->url($i) }}">{{
                                                        $i }}</a>
                                                </li>
                                                @endfor

                                                @if ($data->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="{{ $data->appends(['search' => request()->search])->nextPageUrl() }}"
                                                        rel="next">Next &raquo;</a>
                                                </li>
                                                @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">Next &raquo;</span>
                                                </li>
                                                @endif
                                        </ul>
                                    </nav>

                                </div>




                                <!-- Pagination -->





                            </div>
                        </div>
                    </div>
                    @else
                    <p class="text-center mt-4" style="color: #000957; font-size: 18px;">No data available.</p>
                    @endif



                    <!-- Modal Structure -->
                    <div id="customModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Add New Data</h2>
                            <form action="{{ route('data.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" data-male="{{ $category->total_male ?? 0 }}"
                                            data-female="{{ $category->total_female ?? 0 }}">
                                            {{ $category->category_name }} - Male: {{ $category->total_male }} Female:
                                            {{ $category->total_female }}
                                        </option>
                                        @endforeach


                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="case_name" class="form-label">Case Name</label>
                                    <input type="text" class="form-control" id="case_name" name="case_name"
                                        placeholder="Enter case name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="male_count" class="form-label">Male Count</label>
                                    <input type="number" class="form-control" id="male_count" name="male_count"
                                        required>
                                </div>



                                <div class="mb-3">
                                    <label for="female_count" class="form-label">Female Count</label>
                                    <input type="number" class="form-control" id="female_count" name="female_count"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>

                                <div class="mb-3">
                                    <label for="percentage" class="form-label">Percentage</label>
                                    <input type="text" class="form-control" id="percentage" readonly>
                                </div>

                                <input type="hidden" id="hidden_percentage" name="percentage">



                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" id="cancelModal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div id="editModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Edit Data</h2>
                            <form id="updateForm" action="{{ route('data.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit_id" name="id">

                                <!-- Optional: If you want to allow updating the category, uncomment the following -->
                                <!--
            <div class="mb-3">
                <label for="edit_category_id" class="form-label">Category</label>
                <select class="form-select" id="edit_category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            -->

                                <div class="mb-3">
                                    <label for="edit_case_name" class="form-label">Case Name</label>
                                    <input type="text" class="form-control" id="edit_case_name" name="case_name"
                                        placeholder="Enter case name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_male_count" class="form-label">Male Count</label>
                                    <input type="number" class="form-control" id="edit_male_count" name="male_count"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_female_count" class="form-label">Female Count</label>
                                    <input type="number" class="form-control" id="edit_female_count" name="female_count"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_percentage" class="form-label">Percentage</label>
                                    <input type="number" class="form-control" id="edit_percentage" name="percentage"
                                        required>
                                </div>

                                <input type="hidden" id="hidden_percentage" name="percentage">


                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="edit_date" name="date" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" id="cancelEditModal">Cancel</button>
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
                                    let dataId = this.dataset.id;

                                    if (confirm("Are you sure you want to delete this data?")) {
                                        fetch(/data/${ dataId }, {
                                            method: "DELETE",
                                            headers: {
                                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                                "Content-Type": "application/json"
                                            }
                                        }).then(response => {
                                            if (response.ok) {
                                                alert("Data deleted successfully!");
                                                location.reload(); // Refresh the page
                                            } else {
                                                alert("Error deleting data.");
                                            }
                                        }).catch(error => {
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

                                    // Remove existing highlights
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
                            var editModal = document.getElementById("editModal");
                            var closeEditModalBtn = document.querySelector("#editModal .close");
                            var cancelEditModalBtn = document.getElementById("cancelEditModal");

                            // Open Edit Modal and populate data
                            document.querySelectorAll(".edit-button").forEach(button => {
                                button.addEventListener("click", function () {
                                    document.getElementById("edit_id").value = this.dataset.id;
                                    document.getElementById("edit_case_name").value = this.dataset.case_name;
                                    document.getElementById("edit_male_count").value = this.dataset.male_count;
                                    document.getElementById("edit_female_count").value = this.dataset.female_count;
                                    document.getElementById("edit_date").value = this.dataset.date;
                                    document.getElementById("edit_percentage").value = this.dataset.percentage;

                                    editModal.style.display = "flex";
                                });
                            });

                            // Close modal when clicking close button
                            closeEditModalBtn.addEventListener("click", function () {
                                editModal.style.display = "none";
                            });

                            // Close modal when clicking cancel button
                            cancelEditModalBtn.addEventListener("click", function () {
                                editModal.style.display = "none";
                            });

                            // Close modal if clicked outside
                            window.addEventListener("click", function (event) {
                                if (event.target === editModal) {
                                    editModal.style.display = "none";
                                }
                            });
                        });
                    </script>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            let categorySelect = document.getElementById("category_id");
                            let maleInput = document.getElementById("male_count");
                            let femaleInput = document.getElementById("female_count");
                            let percentageInput = document.getElementById("percentage");
                            let hiddenPercentageInput = document.getElementById("hidden_percentage");

                            function updatePercentage() {
                                let maleCount = parseInt(maleInput.value) || 0;
                                let femaleCount = parseInt(femaleInput.value) || 0;
                                let selectedOption = categorySelect.options[categorySelect.selectedIndex];
                                let totalMale = parseInt(selectedOption.getAttribute("data-male")) || 0;
                                let totalFemale = parseInt(selectedOption.getAttribute("data-female")) || 0;

                                let totalCategoryCases = totalMale + totalFemale;
                                let newCases = maleCount + femaleCount;

                                let percentage = totalCategoryCases > 0 ? (newCases / totalCategoryCases) * 100 : 0;
                                percentageInput.value = percentage.toFixed(2) + "%";
                                hiddenPercentageInput.value = percentage.toFixed(2); // Store the value without "%"
                            }

                            categorySelect.addEventListener("change", updatePercentage);
                            maleInput.addEventListener("input", updatePercentage);
                            femaleInput.addEventListener("input", updatePercentage);
                        });




                    </script>




                </div>
            </main>
            @include('staff.footer')
        </div>
    </div>
    @include('staff.js')

    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
</body>

</html>
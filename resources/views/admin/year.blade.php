<!DOCTYPE html>
<html lang="en">

<head>
    @include('staff.css')
    <style>
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
        @include('admin.sidebar')

        <div class="main">
            @include('staff.header')
            <main class="content">
                <div class="container-fluid p-0">

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h1 style="color:#000957;" class="h3 mb-3">Year</h1>
                        <div class="d-flex gap-2" style="width: 100%; max-width: 400px;">


                            <!-- Add Button -->
                            <button id="openModal" class="w-50 mb-3" style="background-color: #000957; color: white;">Add</button>
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

                <!-- Search Field with Icon (Next to the Separator) -->
                <div class="position-relative" style="width: 250px;">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i data-feather="search"></i></span>
                        <input type="text" class="form-control" placeholder="Search..." style="background-color: white; color: black;">
                    </div>
                </div>
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





                    <div class="row">
                        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                            <div class="card flex-fill" id="dataTable">
                                
                                <table class="table table-hover my-0">
                                    <thead>
                                        <tr  style="color: white;">
                                            <th>CATEGORY</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background-color: white;">
    @foreach ($years as $year)
        <tr>
            <td>{{ $year->year }}</td>
            <td>
                <!-- Edit Button -->
                <button class="btn btn-warning btn-sm edit-btn" 
                        data-id="{{ $year->id }}" 
                        data-name="{{ $year->year }}">
                    Edit
                </button>

                <!-- Delete Button -->
                <form action="{{ route('year.destroy', $year->id) }}" method="POST" class="delete-form" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $year->id }}">Delete</button>
            </form>

            </td>
        </tr>
    @endforeach
</tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Structure -->
                    <div id="customModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Add New Category</h2>
                            <form action="{{ route('year.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Year</label>
                                    <input type="text" class="form-control" id="category_name" name="year" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" id="cancelModal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <!-- Update Category Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeEditModal">&times;</span>
        <h2>Edit Category</h2>
        <form id="editCategoryForm" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" id="edit_category_id" name="id">
    <div class="mb-3">
        <label for="edit_category_name" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="edit_category_name" name="year" required>
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancelEditModal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

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

                        document.addEventListener("DOMContentLoaded", function () {
    var editModal = document.getElementById("editModal");
    var closeEditModalBtn = document.getElementById("closeEditModal");
    var cancelEditModalBtn = document.getElementById("cancelEditModal");
    var editCategoryForm = document.getElementById("editCategoryForm");

    // Open Edit Modal with Data
    document.querySelectorAll(".edit-btn").forEach(button => {
    button.addEventListener("click", function () {
        let categoryId = this.dataset.id;
        document.getElementById("editCategoryForm").action = `/year/${categoryId}`; // ✅ Correctly sets form action
        document.getElementById("edit_category_id").value = categoryId;
        document.getElementById("edit_category_name").value = this.dataset.name;
        document.getElementById("editModal").style.display = "flex";
    });



});

    // Close Edit Modal
    closeEditModalBtn.addEventListener("click", function () {
        editModal.style.display = "none";
    });

    cancelEditModalBtn.addEventListener("click", function () {
        editModal.style.display = "none";
    });

    // Close if clicked outside the modal
    window.addEventListener("click", function (event) {
        if (event.target === editModal) {
            editModal.style.display = "none";
        }
    });
});
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                let categoryId = this.dataset.id;
                if (confirm("Are you sure you want to delete this category?")) {
                    this.closest("form").submit();
                }
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

    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
</body>

</html>

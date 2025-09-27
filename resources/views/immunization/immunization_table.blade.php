<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Immunization Data Table</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<style>
    .custom-pagination .page-item { margin: 0 3px; }
    .custom-pagination .page-link { color: #4f46e5 !important; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; padding: 10px 16px; font-weight: 500; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);}
    .custom-pagination .page-link:hover { background: rgba(255, 255, 255, 1); border-color: #4f46e5; color: #4f46e5 !important; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);}
    .custom-pagination .page-item.active .page-link { background: linear-gradient(135deg, #4f46e5, #7c3aed); border-color: #4f46e5; color: white !important; box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);}
    .custom-pagination .page-item.disabled .page-link { background: rgba(255, 255, 255, 0.5); border-color: rgba(255, 255, 255, 0.3); color: rgba(107, 114, 128, 0.6) !important; cursor: not-allowed; box-shadow: none;}
    .pagination-container { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; padding: 20px; border-radius: 16px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); margin-top: 20px;}
    .pagination-container p { margin: 0; color: white; font-weight: 500; font-size: 14px;}
    .card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1); overflow: hidden;}
    .table { margin: 0; border-radius: 20px; overflow: hidden;}
    .table thead th { background: linear-gradient(135deg, #1f2937, #374151); color: white; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; padding: 20px 15px; border: none; position: sticky; top: 0; z-index: 10;}
    .table tbody td { padding: 18px 15px; vertical-align: middle; border-bottom: 1px solid rgba(0, 0, 0, 0.05); font-weight: 500; color: #374151;}
    .table tbody tr { background: white; transition: all 0.3s ease;}
    .table tbody tr:hover { background: linear-gradient(135deg, rgba(79, 70, 229, 0.03), rgba(124, 58, 237, 0.03)); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);}
    .table tbody tr.selected { background: linear-gradient(135deg, rgba(239, 68, 68, 0.05), rgba(220, 38, 38, 0.05)); border-left: 4px solid #ef4444;}
    .btn { border-radius: 10px; font-weight: 500; padding: 8px 16px; font-size: 13px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: none; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);}
    .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);}
    .btn-warning { background: linear-gradient(135deg, #f59e0b, #d97706); color: white;}
    .btn-warning:hover { background: linear-gradient(135deg, #d97706, #b45309); color: white;}
    .btn-danger { background: linear-gradient(135deg, #ef4444, #dc2626); color: white;}
    .btn-danger:hover { background: linear-gradient(135deg, #dc2626, #b91c1c); color: white;}
    .btn-success { background: linear-gradient(135deg, #10b981, #059669); color: white;}
    .btn-success:hover { background: linear-gradient(135deg, #059669, #047857); color: white;}
    .no-data-message { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);}
    .no-data-message p { color: #374151; font-size: 18px; margin: 0; font-weight: 500;}
    .coverage-badge { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; color: white;}
    .coverage-high { background: linear-gradient(135deg, #10b981, #059669); }
    .coverage-medium { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .coverage-low { background: linear-gradient(135deg, #ef4444, #dc2626); }
    
    /* Checkbox Styling */
    .checkbox-container { display: flex; align-items: center; justify-content: center; }
    .custom-checkbox { position: relative; display: inline-block; width: 20px; height: 20px; }
    .custom-checkbox input[type="checkbox"] { opacity: 0; width: 0; height: 0; }
    .checkmark { position: absolute; top: 0; left: 0; height: 20px; width: 20px; background: rgba(255, 255, 255, 0.9); border: 2px solid #d1d5db; border-radius: 6px; transition: all 0.3s ease; cursor: pointer; }
    .custom-checkbox:hover .checkmark { border-color: #ef4444; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2); }
    .custom-checkbox input:checked ~ .checkmark { background: linear-gradient(135deg, #ef4444, #dc2626); border-color: #ef4444; }
    .checkmark:after { content: ""; position: absolute; display: none; left: 6px; top: 2px; width: 6px; height: 10px; border: solid white; border-width: 0 2px 2px 0; transform: rotate(45deg); }
    .custom-checkbox input:checked ~ .checkmark:after { display: block; }
    
    /* Bulk Actions Bar */
    .bulk-actions-bar { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #1f2937, #374151); color: white; padding: 15px 25px; border-radius: 50px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); z-index: 1000; display: none; animation: slideUp 0.3s ease-out; }
    .bulk-actions-bar.show { display: flex; align-items: center; gap: 15px; }
    .selected-count { background: rgba(239, 68, 68, 0.2); padding: 8px 16px; border-radius: 20px; font-weight: 600; border: 1px solid rgba(239, 68, 68, 0.3); }
    
    @keyframes slideUp { from { transform: translate(-50%, 100%); opacity: 0; } to { transform: translate(-50%, 0); opacity: 1; } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes modalSlideIn { from { transform: scale(0.7); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    
    @media (max-width: 768px) {
        .table-responsive { border-radius: 16px;}
        .pagination-container { flex-direction: column; gap: 15px;}
        .custom-pagination { justify-content: center;}
        .bulk-actions-bar { left: 10px; right: 10px; transform: none; border-radius: 15px; }
    }
    .table-container { max-height: 600px; overflow-y: auto; border-radius: 20px;}
    .table-container::-webkit-scrollbar { width: 8px;}
    .table-container::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.1); border-radius: 10px;}
    .table-container::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 10px;}
    .stats-badge { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; padding: 8px 16px; color: white; font-size: 13px; font-weight: 500; margin-left: 10px;}
    .sort-icon { margin-left: 5px; }

    .modern-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 24px;
        border-radius: 12px;
        color: white;
        font-weight: 500;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        z-index: 10001;
        max-width: 400px;
        opacity: 1;
        transform: translateX(0);
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    .modern-alert.success { background: linear-gradient(135deg, #10b981, #059669); }
    .modern-alert.error { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .modern-alert.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
</style>

@if($data->isNotEmpty())
<div class="row">
    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill" id="dataTable">
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">
                            <div class="checkbox-container">
                                <label class="custom-checkbox">
                                    <input type="checkbox" id="selectAll">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </th>
                        <th onclick="sortTable(1, 'date')">
                            Date <i class="fas fa-sort sort-icon" id="icon-1"></i>
                        </th>
                        <th onclick="sortTable(2, 'string')">
                            Vaccine Name <i class="fas fa-sort sort-icon" id="icon-2"></i>
                        </th>
                        <th onclick="sortTable(3, 'number')">
                            Male <i class="fas fa-sort sort-icon" id="icon-3"></i>
                        </th>
                        <th onclick="sortTable(4, 'number')">
                            Female <i class="fas fa-sort sort-icon" id="icon-4"></i>
                        </th>
                        <th>Total Vaccinated</th>
                        <th>Coverage</th>
                        <th class="no-print">Actions</th>
                    </tr>
                </thead>

                <tbody style="background-color: white;">
                    @php $estimatedPopulation = 3000; @endphp
                    @foreach($data as $row)
                        @php
                            $totalVaccinated = $row->male_vaccinated + $row->female_vaccinated;
                            $coveragePercentage = $estimatedPopulation > 0 ? ($totalVaccinated / $estimatedPopulation) * 100 : 0;
                            $coverageClass = 'coverage-low';
                            if ($coveragePercentage >= 80) $coverageClass = 'coverage-high';
                            elseif ($coveragePercentage >= 50) $coverageClass = 'coverage-medium';
                        @endphp
                        <tr data-id="{{ $row->id }}">
                            <td>
                                <div class="checkbox-container">
                                    <label class="custom-checkbox">
                                        <input type="checkbox" class="row-checkbox" data-id="{{ $row->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($row->date)->format('m-d-Y') }}</td>
                            <td>{{ strtoupper($row->vaccine_name) }}</td>
                            <td>{{ number_format($row->male_vaccinated) }}</td>
                            <td>{{ number_format($row->female_vaccinated) }}</td>
                            <td>{{ number_format($totalVaccinated) }}</td>
                            <td>
                                <span class="coverage-badge {{ $coverageClass }}">
                                    {{ number_format($coveragePercentage, 2) }}%
                                </span>
                            </td>
                            <td class="no-print">
                                <button class="btn btn-warning btn-sm edit-button"
                                    data-id="{{ $row->id }}"
                                    data-vaccine="{{ $row->vaccine_name }}"
                                    data-date="{{ $row->date }}"
                                    data-male="{{ $row->male_vaccinated }}"
                                    data-female="{{ $row->female_vaccinated }}">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm delete-button" data-id="{{ $row->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @php
                $start = max(1, $data->currentPage() - 2);
                $end = min($data->lastPage(), $start + 3);
                if ($end - $start < 3) { $start = max(1, $end - 3); }
            @endphp

            <div class="pagination-container mt-3 no-print">
                <p>Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} results</p>
                <nav>
                    <ul class="pagination custom-pagination">
                        @if ($data->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo; Previous</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $data->appends(request()->except('page'))->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                            </li>
                        @endif

                        @if ($start > 1)
                            <li class="page-item"><a class="page-link" href="{{ $data->appends(request()->except('page'))->url(1) }}">1</a></li>
                            @if ($start > 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $data->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $data->appends(request()->except('page'))->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($end < $data->lastPage())
                            @if ($end < $data->lastPage() - 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item"><a class="page-link" href="{{ $data->appends(request()->except('page'))->url($data->lastPage()) }}">{{ $data->lastPage() }}</a></li>
                        @endif

                        @if ($data->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $data->appends(request()->except('page'))->nextPageUrl() }}" rel="next">Next &raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Next &raquo;</span></li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Actions Bar -->
<div class="bulk-actions-bar" id="bulkActionsBar">
    <div class="selected-count">
        <i class="fas fa-check-circle"></i>
        <span id="selectedCount">0</span> selected
    </div>
    <button class="btn btn-danger" id="deleteSelectedBtn">
        <i class="fas fa-trash"></i> Delete Selected
    </button>
    <button class="btn btn-success" id="selectAllVisible">
        <i class="fas fa-check-double"></i> Select All
    </button>
    <button class="btn btn-secondary" id="clearSelection">
        <i class="fas fa-times"></i> Clear Selection
    </button>
</div>

@else
    <div class="no-data-message">
        <p>No immunization data available.</p>
    </div>
@endif

<script>
let sortDirections = {}; // Track sort state per column

function sortTable(colIndex, type = 'string') {
    const table = document.querySelector(".table tbody");
    const rows = Array.from(table.rows);
    const icon = document.getElementById("icon-" + colIndex);

    // Toggle sort direction
    sortDirections[colIndex] = !sortDirections[colIndex];
    const direction = sortDirections[colIndex] ? 1 : -1;

    // Reset all icons first
    document.querySelectorAll(".sort-icon").forEach(i => i.className = "fas fa-sort sort-icon");

    // Sorting logic
    rows.sort((a, b) => {
        let A = a.cells[colIndex].innerText.trim();
        let B = b.cells[colIndex].innerText.trim();

        if (type === "number") {
            A = parseFloat(A.replace(/,/g, "")) || 0;
            B = parseFloat(B.replace(/,/g, "")) || 0;
        } else if (type === "date") {
            A = new Date(A);
            B = new Date(B);
        } else {
            A = A.toLowerCase();
            B = B.toLowerCase();
        }

        if (A < B) return -1 * direction;
        if (A > B) return 1 * direction;
        return 0;
    });

    // Re-attach sorted rows
    rows.forEach(row => table.appendChild(row));

    // Update icon
    icon.className = "fas " + (direction === 1 ? "fa-sort-up" : "fa-sort-down") + " sort-icon";
}

// Enhanced showModernAlert function
if (typeof window.showModernAlert === 'undefined') {
    window.showModernAlert = function(title, message, type = 'success') {
        const alertBox = document.createElement('div');
        alertBox.className = `modern-alert ${type}`;
        alertBox.innerHTML = `<strong>${title}</strong><br><span style="color:#ccc;">${message}</span>`;
        document.body.appendChild(alertBox);

        setTimeout(() => {
            alertBox.style.opacity = "0";
            alertBox.style.transform = "translateX(100%)";
            setTimeout(() => {
                if (alertBox.parentNode) {
                    alertBox.remove();
                }
            }, 500);
        }, 3000);
    };
}

// Selective Delete Functionality
document.addEventListener("DOMContentLoaded", function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    const selectedCountElement = document.getElementById('selectedCount');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    const selectAllVisibleBtn = document.getElementById('selectAllVisible');
    const clearSelectionBtn = document.getElementById('clearSelection');

    // Update bulk actions bar visibility and count
    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const count = checkedBoxes.length;
        
        selectedCountElement.textContent = count;
        
        if (count > 0) {
            bulkActionsBar.classList.add('show');
            // Highlight selected rows
            document.querySelectorAll('tbody tr').forEach(row => {
                const checkbox = row.querySelector('.row-checkbox');
                if (checkbox && checkbox.checked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
            });
        } else {
            bulkActionsBar.classList.remove('show');
            document.querySelectorAll('tbody tr').forEach(row => {
                row.classList.remove('selected');
            });
        }

        // Update select all checkbox state
        const allCheckboxes = document.querySelectorAll('.row-checkbox');
        const allChecked = allCheckboxes.length === checkedBoxes.length && allCheckboxes.length > 0;
        const someChecked = checkedBoxes.length > 0;
        
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
        }
    }

    // Individual checkbox change
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('row-checkbox')) {
            updateBulkActions();
        }
    });

    // Select All checkbox
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateBulkActions();
        });
    }

    // Select All Visible button
    if (selectAllVisibleBtn) {
        selectAllVisibleBtn.addEventListener('click', function() {
            document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                checkbox.checked = true;
            });
            updateBulkActions();
        });
    }

    // Clear Selection button
    if (clearSelectionBtn) {
        clearSelectionBtn.addEventListener('click', function() {
            document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            updateBulkActions();
        });
    }

    // Delete Selected button
    if (deleteSelectedBtn) {
        deleteSelectedBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            const selectedIds = Array.from(checkedBoxes).map(checkbox => checkbox.dataset.id);
            
            if (selectedIds.length === 0) {
                showModernAlert("⚠️ Warning", "No records selected for deletion.", "warning");
                return;
            }

            // Create modern confirmation modal
            const confirmOverlay = document.createElement('div');
            confirmOverlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.8);
                backdrop-filter: blur(10px);
                z-index: 10000;
                display: flex;
                justify-content: center;
                align-items: center;
                animation: fadeIn 0.3s ease-out;
            `;

            const confirmBox = document.createElement('div');
            confirmBox.style.cssText = `
                background: linear-gradient(135deg, #1e1e2f, #2a2a3e);
                border-radius: 25px;
                padding: 2.5rem;
                max-width: 480px;
                width: 90%;
                text-align: center;
                color: #fff;
                box-shadow: 0 20px 60px rgba(0,0,0,0.5);
                animation: modalSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
                border: 1px solid rgba(255, 255, 255, 0.1);
            `;

            confirmBox.innerHTML = `
                <div style="margin-bottom: 1.5rem;">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ff4757, #ff3838); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; animation: pulse 2s infinite;">
                        🗑️
                    </div>
                    <h3 style="margin-bottom: 1rem; font-size: 1.6rem; background: linear-gradient(135deg, #ff4757, #ff6b7a); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Confirm Delete Selected</h3>
                    <p style="margin-bottom: 2rem; font-size: 1.1rem; color: #ccc; line-height: 1.5;">
                        This action will permanently delete <strong>${selectedIds.length} selected record${selectedIds.length > 1 ? 's' : ''}</strong> from the immunization table. 
                        <br><br>
                        <span style="color: #ff6b7a; font-weight: 600;">⚠️ This action cannot be undone!</span>
                    </p>
                </div>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <button id="cancelDelete" style="background: linear-gradient(135deg, #6c757d, #8a94a6); border: none; border-radius: 15px; padding: 12px 24px; color: white; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;">
                        <span>❌</span> Cancel
                    </button>
                    <button id="confirmDelete" style="background: linear-gradient(135deg, #ff4757, #ff3838); border: none; border-radius: 15px; padding: 12px 24px; color: white; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);">
                        <span>🗑️</span> Delete Selected
                    </button>
                </div>
            `;

            confirmOverlay.appendChild(confirmBox);
            document.body.appendChild(confirmOverlay);

            // Add hover effects
            const cancelBtn = confirmBox.querySelector("#cancelDelete");
            const confirmBtn = confirmBox.querySelector("#confirmDelete");

            cancelBtn.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 6px 20px rgba(108, 117, 125, 0.4)';
            });

            cancelBtn.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });

            confirmBtn.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 8px 25px rgba(255, 71, 87, 0.5)';
            });

            confirmBtn.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 15px rgba(255, 71, 87, 0.3)';
            });

            // Cancel action
            cancelBtn.addEventListener("click", () => {
                confirmOverlay.remove();
            });

            // Confirm action - Delete selected records
            confirmBtn.addEventListener("click", () => {
                // Show loading state
                confirmBtn.innerHTML = '<span>⏳</span> Deleting...';
                confirmBtn.disabled = true;
                cancelBtn.disabled = true;

                // Make the delete selected request
                fetch("{{ url('/immunization/delete-selected') }}", {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    })
                    .then(response => response.json())
                    .then(data => {
                        confirmOverlay.remove();
                        if (data.success) {
                            // Remove deleted rows from DOM
                            selectedIds.forEach(id => {
                                const row = document.querySelector(`tr[data-id="${id}"]`);
                                if (row) {
                                    row.remove();
                                }
                            });

                            // Update pagination info if needed
                            const remainingRows = document.querySelectorAll('tbody tr').length;
                            const paginationInfo = document.querySelector('.pagination-container p');
                            if (paginationInfo && remainingRows === 0) {
                                paginationInfo.textContent = 'Showing 0 to 0 of 0 results';
                                
                                // Hide pagination
                                const pagination = document.querySelector('.pagination');
                                if (pagination) {
                                    pagination.style.display = 'none';
                                }

                                // Show no data message
                                const tableContainer = document.querySelector('#dataTable .card');
                                if (tableContainer) {
                                    tableContainer.innerHTML = `
                                        <div class="no-data-message">
                                            <p>No immunization data available.</p>
                                        </div>
                                    `;
                                }
                            }

                            // Clear selection and update bulk actions
                            document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                                checkbox.checked = false;
                            });
                            updateBulkActions();

                            showModernAlert("✅ Success", 
                                `Successfully deleted ${data.deleted_count} record${data.deleted_count > 1 ? 's' : ''}!`, 
                                "success");
                        } else {
                            showModernAlert("❌ Error", data.message || "Failed to delete selected records.", "error");
                        }
                    })
                    .catch(error => {
                        confirmOverlay.remove();
                        console.error("Error:", error);
                        showModernAlert("❌ Error", "Something went wrong while deleting selected records.", "error");
                    });
            });

            // Close on outside click
            confirmOverlay.addEventListener('click', function(e) {
                if (e.target === confirmOverlay) {
                    confirmOverlay.remove();
                }
            });
        });
    }

    // Initial update
    updateBulkActions();
});
</script>
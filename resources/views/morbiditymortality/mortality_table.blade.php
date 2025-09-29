<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern mortality Data Table</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<style>
    .custom-pagination .page-item {
        margin: 0 3px;
    }

    .custom-pagination .page-link {
        color: #4f46e5 !important;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .custom-pagination .page-link:hover {
        background: rgba(255, 255, 255, 1);
        border-color: #4f46e5;
        color: #4f46e5 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }

    .custom-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-color: #4f46e5;
        color: white !important;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
    }

    .custom-pagination .page-item.disabled .page-link {
        background: rgba(255, 255, 255, 0.5);
        border-color: rgba(255, 255, 255, 0.3);
        color: rgba(107, 114, 128, 0.6) !important;
        cursor: not-allowed;
        box-shadow: none;
    }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding: 20px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        margin-top: 20px;
    }

    .pagination-container p {
        margin: 0;
        color: white;
        font-weight: 500;
        font-size: 14px;
    }

    .table {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table {
        margin: 0;
        border-radius: 20px;
        overflow: hidden;
    }

    .table thead th {
        background: linear-gradient(135deg, #1f2937, #374151);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 1px;
        padding: 20px 15px;
        border: none;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table tbody td {
        padding: 18px 15px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-weight: 500;
        color: #374151;
    }

    .table tbody tr {
        background: white;
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.03), rgba(124, 58, 237, 0.03));
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .table tbody tr.selected {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.05), rgba(220, 38, 38, 0.05));
        border-left: 4px solid #ef4444;
    }

    .btn {
        border-radius: 10px;
        font-weight: 500;
        padding: 8px 16px;
        font-size: 13px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #8a94a6);
        color: white;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #8a94a6, #5a6268);
        color: white;
    }

    .no-data-message {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .no-data-message p {
        color: #374151;
        font-size: 18px;
        margin: 0;
        font-weight: 500;
    }

    .coverage-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: white;
    }

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
        .table-responsive {
            border-radius: 16px;
        }
        
        .pagination-container {
            flex-direction: column;
            gap: 15px;
        }
        
        .custom-pagination {
            justify-content: center;
        }

        .bulk-actions-bar { left: 10px; right: 10px; transform: none; border-radius: 15px; }
    }

    .table-container {
        max-height: 600px;
        overflow-y: auto;
        border-radius: 20px;
    }

    .table-container::-webkit-scrollbar {
        width: 8px;
    }

    .table-container::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-radius: 10px;
    }

    .stats-badge {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 8px 16px;
        color: white;
        font-size: 13px;
        font-weight: 500;
        margin-left: 10px;
    }
    .percentage-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }

    .percentage-high { 
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    .percentage-medium { 
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }
    .percentage-low { 
        background: linear-gradient(135deg, #10b981, #059669);
    }

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
                <div class="table flex-fill" id="dataTable">
                    <table class="table table-hover my-0">
                        <thead>
    <tr style="color: white;">
        <th style="width: 50px;">
            <div class="checkbox-container">
                <label class="custom-checkbox">
                    <input type="checkbox" id="selectAll">
                    <span class="checkmark"></span>
                </label>
            </div>
        </th>
        <th onclick="sortTable2(1,'date')">DATE <i id="icon2-1" class="fas fa-sort sort-icon"></i></th>
        <th onclick="sortTable2(2,'string')">CASES <i id="icon2-2" class="fas fa-sort sort-icon"></i></th>
        <th onclick="sortTable2(3,'number')">MALE COUNT <i id="icon2-3" class="fas fa-sort sort-icon"></i></th>
        <th onclick="sortTable2(4,'number')">FEMALE COUNT <i id="icon2-4" class="fas fa-sort sort-icon"></i></th>
        <th onclick="sortTable2(5,'number')">TOTAL COUNT <i id="icon2-5" class="fas fa-sort sort-icon"></i></th>
        <th onclick="sortTable2(6,'number')">PERCENTAGE <i id="icon2-6" class="fas fa-sort sort-icon"></i></th>
        <th>ACTIONS</th>
    </tr>
</thead>
<script>
let sortDirections2 = {};

function sortTable2(colIndex, type = 'string') {
    const table = document.querySelector("#dataTable tbody");
    const rows = Array.from(table.rows);
    const icon = document.getElementById("icon2-" + colIndex);

    sortDirections2[colIndex] = !sortDirections2[colIndex];
    const direction = sortDirections2[colIndex] ? 1 : -1;

    document.querySelectorAll("[id^='icon2-']").forEach(i => i.className = "fas fa-sort sort-icon");

    rows.sort((a, b) => {
        let A = a.cells[colIndex].innerText.trim().replace('%','');
        let B = b.cells[colIndex].innerText.trim().replace('%','');

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

    table.innerHTML = "";
    rows.forEach(row => table.appendChild(row));

    icon.className = "fas " + (direction === 1 ? "fa-sort-up" : "fa-sort-down") + " sort-icon";
}
</script>


                        <tbody style="background-color: white;">
                            @foreach($data as $row)
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
                                                                <td>{{strtoupper($row->case_name) }}</td>
                                                                <td>{{ $row->male_count }}</td>
                                                                <td>{{ $row->female_count }}</td>
                                                                <td>{{ $row->male_count + $row->female_count }}</td>
                                                                <td class="percentage-cell" data-total="{{ $row->male_count + $row->female_count }}">0%</td>
                                                                <td class="no-print">
                                                                    <button class="btn btn-warning btn-sm edit-button"
                                                                        data-id="{{ $row->id }}" 
                                                                        data-date="{{ $row->date }}"
                                                                        data-case_name="{{ $row->case_name }}"
                                                                        data-male_count="{{ $row->male_count }}"
                                                                        data-female_count="{{ $row->female_count }}">
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

                    @php
                        $start = max(1, $data->currentPage() - 2);
                        $end = min($data->lastPage(), $start + 3);

                        if ($end - $start < 3) {
                            $start = max(1, $end - 3);
                        }
                    @endphp

                    <div class="pagination-container mt-3 no-print">
                        <p>Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} results</p>
                        <nav>
                            <ul class="pagination custom-pagination">
                                @if ($data->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">&laquo; Previous</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $data->appends(['search' => request()->search])->previousPageUrl() }}"
                                            rel="prev">&laquo; Previous</a>
                                    </li>
                                @endif

                                @if ($start > 1)
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $data->appends(['search' => request()->search])->url(1) }}">1</a></li>
                                    @if ($start > 2)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif

                                @for ($i = $start; $i <= $end; $i++)
                                    <li class="page-item {{ $i == $data->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $data->appends(['search' => request()->search])->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($end < $data->lastPage())
                                    @if ($end < $data->lastPage() - 1)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $data->appends(['search' => request()->search])->url($data->lastPage()) }}">{{ $data->lastPage() }}</a>
                                    </li>
                                @endif

                                @if ($data->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $data->appends(['search' => request()->search])->nextPageUrl() }}"
                                            rel="next">Next &raquo;</a>
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
    <p class="text-center mt-4" style="color: #000957; font-size: 18px;">No data available.</p>
@endif

<script>
   document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll("#dataTable tbody tr");

    // Step 1: calculate totals per case_name
    let caseTotals = {};
    rows.forEach(row => {
        let caseName = row.cells[1].innerText.trim().toUpperCase(); // normalize
        const total = parseInt(row.querySelector(".percentage-cell").dataset.total) || 0;

        caseTotals[caseName] = (caseTotals[caseName] || 0) + total;
    });

    // Step 2: update percentage per row based on its own case_name total
    rows.forEach(row => {
        let caseName = row.cells[1].innerText.trim().toUpperCase();
        const cell = row.querySelector(".percentage-cell");
        const rowTotal = parseInt(cell.dataset.total) || 0;

        const percentage = caseTotals[caseName] > 0
            ? ((rowTotal / caseTotals[caseName]) * 100).toFixed(2)
            : 0;

        // Decide color class
        let colorClass = 'percentage-low';
        if (percentage >= 30) {
            colorClass = 'percentage-high';
        } else if (percentage >= 15) {
            colorClass = 'percentage-medium';
        }

        cell.innerHTML = `<span class="percentage-badge ${colorClass}">${percentage}%</span>`;
    });

        // Bulk delete functionality
        const selectAllCheckbox = document.getElementById('selectAll');
        const bulkActionsBar = document.getElementById('bulkActionsBar');
        const selectedCountElement = document.getElementById('selectedCount');
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
        const selectAllVisibleBtn = document.getElementById('selectAllVisible');
        const clearSelectionBtn = document.getElementById('clearSelection');

        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            const count = checkedBoxes.length;
            
            selectedCountElement.textContent = count;
            
            if (count > 0) {
                bulkActionsBar.classList.add('show');
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

            const allCheckboxes = document.querySelectorAll('.row-checkbox');
            const allChecked = allCheckboxes.length === checkedBoxes.length && allCheckboxes.length > 0;
            const someChecked = checkedBoxes.length > 0;
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
        }

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('row-checkbox')) {
                updateBulkActions();
            }
        });

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateBulkActions();
            });
        }

        if (selectAllVisibleBtn) {
            selectAllVisibleBtn.addEventListener('click', function() {
                document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                    checkbox.checked = true;
                });
                updateBulkActions();
            });
        }

        if (clearSelectionBtn) {
            clearSelectionBtn.addEventListener('click', function() {
                document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });
                updateBulkActions();
            });
        }

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

        if (deleteSelectedBtn) {
            deleteSelectedBtn.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
                const selectedIds = Array.from(checkedBoxes).map(checkbox => checkbox.dataset.id);
                
                if (selectedIds.length === 0) {
                    showModernAlert("⚠️ Warning", "No records selected for deletion.", "warning");
                    return;
                }

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
                            This action will permanently delete <strong>${selectedIds.length} selected record${selectedIds.length > 1 ? 's' : ''}</strong> from the mortality table. 
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

                cancelBtn.addEventListener("click", () => {
                    confirmOverlay.remove();
                });

                confirmBtn.addEventListener("click", () => {
                    confirmBtn.innerHTML = '<span>⏳</span> Deleting...';
                    confirmBtn.disabled = true;
                    cancelBtn.disabled = true;

                    fetch("{{ url('/mortality/delete-selected') }}", {
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
                                selectedIds.forEach(id => {
                                    const row = document.querySelector(`tr[data-id="${id}"]`);
                                    if (row) {
                                        row.remove();
                                    }
                                });

                                const remainingRows = document.querySelectorAll('tbody tr').length;
                                const paginationInfo = document.querySelector('.pagination-container p');
                                if (paginationInfo && remainingRows === 0) {
                                    paginationInfo.textContent = 'Showing 0 to 0 of 0 results';
                                    
                                    const pagination = document.querySelector('.pagination');
                                    if (pagination) {
                                        pagination.style.display = 'none';
                                    }

                                    const tableContainer = document.querySelector('#dataTable .table');
                                    if (tableContainer) {
                                        tableContainer.parentElement.innerHTML = `
                                            <p class="text-center mt-4" style="color: #000957; font-size: 18px;">No data available.</p>
                                        `;
                                    }
                                }

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

                confirmOverlay.addEventListener('click', function(e) {
                    if (e.target === confirmOverlay) {
                        confirmOverlay.remove();
                    }
                });
            });
        }

        updateBulkActions();
    });
</script>

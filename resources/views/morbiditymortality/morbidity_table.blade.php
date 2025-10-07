@if($data->isNotEmpty())
        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="table flex-fill" id="dataTable">
                    <table class="table table-hover my-0">
                        <thead>
    <tr style="color: white;">
        <th onclick="sortTable2(0,'date')">DATE <i id="icon2-0" class="fas fa-sort sort-icon"></i></th>
        <th onclick="sortTable2(1,'string')">CASES <i id="icon2-1" class="fas fa-sort sort-icon"></i></th>
        <th onclick="sortTable2(2,'number')">MALE COUNT <i id="icon2-2" class="fas fa-sort sort-icon"></i></th>
        <th onclick="sortTable2(3,'number')">FEMALE COUNT <i id="icon2-3" class="fas fa-sort sort-icon"></i></th>
        <th onclick="sortTable2(4,'number')">TOTAL COUNT <i id="icon2-4" class="fas fa-sort sort-icon"></i></th>
        <th onclick="sortTable2(5,'number')">PERCENTAGE 
        <th>ACTIONS</th>
    </tr>
</thead>

<script>
let sortDirections2 = {};

function sortTable2(colIndex, type = 'string') {
    const table = document.querySelector("#dataTable tbody");
    const rows = Array.from(table.rows);
    const icon = document.getElementById("icon2-" + colIndex);

    // Toggle sort direction
    sortDirections2[colIndex] = !sortDirections2[colIndex];
    const direction = sortDirections2[colIndex] ? 1 : -1;

    // Reset all icons
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

    // Re-attach sorted rows
    table.innerHTML = "";
    rows.forEach(row => table.appendChild(row));

    
    icon.className = "fas " + (direction === 1 ? "fa-sort-up" : "fa-sort-down") + " sort-icon";
}
</script>

                        <tbody style="background-color: white;">
                            @foreach($data as $row)
                                                            <tr>
                                                                <td>{{ \Carbon\Carbon::parse($row->date)->format('m-d-Y') }}</td>
                                                                <td>{{strtoupper($row->case_name) }}</td>
                                                                <td>{{ $row->male_count }}</td>
                                                                <td>{{ $row->female_count }}</td>
                                                                <td>{{ $row->male_count + $row->female_count }}</td>
                                                                <td class="percentage-cell" data-total="{{ $row->male_count + $row->female_count }}">0%</td>
                                                                
                                                                <td>
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

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="mb-0" style="color: white !important;">
                            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} results
                        </p>

                        <nav>
                           <div class="pagination-container mt-3 no-print">
    <p>Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} results</p>
    <nav>
        <ul class="pagination custom-pagination">
            {{-- Previous Button --}}
            @if ($data->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo; Previous</span></li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $data->appends(request()->except('page'))->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                </li>
            @endif

            {{-- First Page Link --}}
            @if ($start > 1)
                <li class="page-item"><a class="page-link" href="{{ $data->appends(request()->except('page'))->url(1) }}">1</a></li>
                @if ($start > 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endif

            {{-- Page Number Links --}}
            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $i == $data->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $data->appends(request()->except('page'))->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Last Page Link --}}
            @if ($end < $data->lastPage())
                @if ($end < $data->lastPage() - 1)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $data->appends(request()->except('page'))->url($data->lastPage()) }}">{{ $data->lastPage() }}</a>
                </li>
            @endif

            {{-- Next Button --}}
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

@else
    <p class="text-center mt-4" style="color: #000957; font-size: 18px;">No data available.</p>
@endif

<script>
document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll("#dataTable tbody tr");

    // Step 1: group totals by normalized case_name
    let caseTotals = {};
    rows.forEach(row => {
        let caseName = row.cells[1].innerText.trim().toUpperCase(); // normalize
        const total = parseInt(row.querySelector(".percentage-cell").dataset.total) || 0;

        caseTotals[caseName] = (caseTotals[caseName] || 0) + total;
    });

    // Step 2: compute percentage for each row within its case group
    rows.forEach(row => {
        let caseName = row.cells[1].innerText.trim().toUpperCase();
        const cell = row.querySelector(".percentage-cell");
        const rowTotal = parseInt(cell.dataset.total) || 0;

        const percentage = caseTotals[caseName] > 0
            ? ((rowTotal / caseTotals[caseName]) * 100).toFixed(2)
            : 0;

        cell.textContent = `${percentage}%`;
    });
});
</script>



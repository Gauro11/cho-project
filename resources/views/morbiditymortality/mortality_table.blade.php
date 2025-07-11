<style>
    .custom-pagination .page-item {
        margin: 0 2px;
    }

    .custom-pagination .page-link {
        color: #fff !important;
        background-color: #007bff;
        border: 1px solid #007bff;
        border-radius: 5px;
        padding: 6px 12px;
        transition: all 0.3s ease;
    }

    .custom-pagination .page-link:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .custom-pagination .page-item.active .page-link {
        background-color:rgb(144, 198, 255);
        border-color: rgb(144, 198, 255);
    }

    .custom-pagination .page-item.disabled .page-link {
        background-color: #6c757d;
        border-color: #6c757d;
        cursor: not-allowed;
    }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding: 10px;
        border-radius: 5px;
    }

    .pagination-container p {
        margin: 0;
        color: white;
    }
</style>


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
                                <th>TOTAL COUNT</th>
                                <th>PERCENTAGE</th>
                                <th>DATE</th>
                                <th class="no-print">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: white;">
                            @foreach($data as $row)
                                                            <tr>
                                                                <td>{{strtoupper($row->case_name) }}</td>
                                                                <td>{{ $row->male_count }}</td>
                                                                <td>{{ $row->female_count }}</td>
                                                                <td>{{ $row->male_count + $row->female_count }}</td>
                                                                <td class="percentage-cell" data-total="{{ $row->male_count + $row->female_count }}">0%</td>
                                                                <td>{{ \Carbon\Carbon::parse($row->date)->format('m-d-Y') }}</td>
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
@else
    <p class="text-center mt-4" style="color: #000957; font-size: 18px;">No data available.</p>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const percentageCells = document.querySelectorAll(".percentage-cell");
        let totalSum = 0;

        // Calculate the total sum of all male and female counts
        percentageCells.forEach(cell => {
            const total = parseInt(cell.getAttribute("data-total")) || 0;
            totalSum += total;
        });

        // Calculate and update the percentage for each row
        percentageCells.forEach(cell => {
            const rowTotal = parseInt(cell.getAttribute("data-total")) || 0;
            const percentage = totalSum > 0 ? ((rowTotal / totalSum) * 100).toFixed(2) : 0;
            cell.textContent = `${percentage}%`;
        });
    });
</script>
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
        background-color: rgb(144, 198, 255);
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
                                <th>ID</th>
                                <th>Year</th>
                                <th>Vaccine Name</th>
                                <th>Male Vaccinated</th>
                                <th>Female Vaccinated</th>
                                <th>Total Vaccinated </th>
                                <th>Coverage </th>
                                <th class="no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: white;">
                            @php
    $estimatedPopulation = 3000; // Adjust as necessary
                            @endphp
                            @foreach($data as $row)
                                                                                    @php
        $totalVaccinated = $row->male_vaccinated + $row->female_vaccinated;
        $coveragePercentage = $estimatedPopulation > 0
            ? ($totalVaccinated / $estimatedPopulation) * 100
            : 0;
                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td>{{ $row->id }}</td>
                                                                                        <td>{{ date('Y', strtotime($row->date)) }}</td>
                                                                                        <td>{{ strtoupper($row->vaccine_name) }}</td>
                                                                                        <td>{{ number_format($row->male_vaccinated) }}</td>
                                                                                        <td>{{ number_format($row->female_vaccinated) }}</td>
                                                                                        <td>{{ number_format($totalVaccinated) }}</td>
                                                                                        <td>{{ number_format($coveragePercentage, 2) }}%</td>
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
    <p class="text-center mt-4" style="color: #000957; font-size: 18px;">No immunization data available.</p>
@endif

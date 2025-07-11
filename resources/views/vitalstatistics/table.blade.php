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
                                <th>Month and Year</th>
                                <th>Population</th>
                                <th>Total Live Births</th>
                                <th>Crude Birth Rate</th>
                                <th>Total Deaths</th>
                                <th>Crude Death Rate</th>
                                <th>Infant Deaths</th>
                                <th>Infant Mortality Rate</th>
                                <th>Maternal Deaths</th>
                                <th>Maternal Mortality Rate</th>
                                <th class="no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: white;">
                            @foreach($data as $row)
                                                    @php
        $population = $row->total_population;
        $births = $row->total_live_births;
        $deaths = $row->total_deaths;
        $infantDeaths = $row->infant_deaths;
        $maternalDeaths = $row->maternal_deaths;

        $crudeBirthRate = $population > 0 ? ($births / $population) * 1000 : 0;
        $crudeDeathRate = $population > 0 ? ($deaths / $population) * 1000 : 0;
        $infantMortalityRate = $births > 0 ? ($infantDeaths / $births) * 1000 : 0;
        $maternalMortalityRate = $births > 0 ? ($maternalDeaths / $births) * 100000 : 0;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $row->year }}</td>
                                                        <td>{{ number_format($population) }}</td>
                                                        <td>{{ number_format($births) }}</td>
                                                        <td>{{ number_format($crudeBirthRate, 2) }}</td>
                                                        <td>{{ number_format($deaths) }}</td>
                                                        <td>{{ number_format($crudeDeathRate, 2) }}</td>
                                                        <td>{{ number_format($infantDeaths) }}</td>
                                                        <td>{{ number_format($infantMortalityRate, 2) }}</td>
                                                        <td>{{ number_format($maternalDeaths) }}</td>
                                                        <td>{{ number_format($maternalMortalityRate, 2) }}</td>
                                                        <td class="no-print">
                                                        <button class="btn btn-warning btn-sm edit-button"
                                                            data-id="{{ $row->id }}" 
                                                            data-year="{{ $row->year }}"
                                                            data-population="{{ $row->total_population }}"
                                                            data-births="{{ $row->total_live_births }}"
                                                            data-deaths="{{ $row->total_deaths }}"
                                                            data-infant="{{ $row->infant_deaths }}"
                                                            data-maternal="{{ $row->maternal_deaths }}">
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
    $end = min($data->lastPage(), $start + 4);

    if ($end - $start < 4) {
        $start = max(1, $end - 4);
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

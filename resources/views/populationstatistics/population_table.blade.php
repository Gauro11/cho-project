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

@php
$barangayCoordinates = [
    'Bacayao Norte' => ['lat' => 16.037346, 'lng' => 120.346786],
    'Bacayao Sur' => ['lat' => 16.030672, 'lng' => 120.341251],
    'Barangay I' => ['lat' => 16.044844, 'lng' => 120.335835],
    'Barangay II' => ['lat' => 16.041909, 'lng' => 120.336434],
    'Barangay IV' => ['lat' => 16.041994, 'lng' => 120.335449],
    'Bolosan' => ['lat' => 16.050444, 'lng' => 120.364059],
    'Bonuan Binloc' => ['lat' => 16.101930, 'lng' => 120.379703],
    'Bonuan Boquig' => ['lat' => 16.077498, 'lng' => 120.358025],
    'Bonuan Gueset' => ['lat' => 16.075381, 'lng' => 120.343179],
    'Calmay' => ['lat' => 16.045288, 'lng' => 120.325569],
    'Carael' => ['lat' => 16.031396, 'lng' => 120.313649],
    'Caranglaan' => ['lat' => 16.030648, 'lng' => 120.349915],
    'Herrero-Perez' => ['lat' => 16.043930, 'lng' => 120.342263],
    'Lasip Chico' => ['lat' => 16.021638, 'lng' => 120.340272],
    'Lasip Grande' => ['lat' => 16.028621, 'lng' => 120.343201],
    'Lomboy' => ['lat' => 16.054649, 'lng' => 120.323475],
    'Lucao' => ['lat' => 16.020486, 'lng' => 120.322627],
    'Malued' => ['lat' => 16.029291, 'lng' => 120.335123],
    'Mamalingling' => ['lat' => 16.056642, 'lng' => 120.362212],
    'Mangin' => ['lat' => 16.038877, 'lng' => 120.367335],
    'Mayombo' => ['lat' => 16.041841, 'lng' => 120.346308],
    'Pantal' => ['lat' => 16.046174, 'lng' => 120.338746],
    'Poblacion Oeste' => ['lat' => 16.042353, 'lng' => 120.330374],
    'Pogo Chico' => ['lat' => 16.038643, 'lng' => 120.337509],
    'Pogo Grande' => ['lat' => 16.032503, 'lng' => 120.336519],
    'Salapingao' => ['lat' => 16.057873, 'lng' => 120.319872],
    'Salisay' => ['lat' => 16.041955, 'lng' => 120.371284],
    'Tambac' => ['lat' => 16.046036, 'lng' => 120.356319],
    'Tapuac' => ['lat' => 16.032397, 'lng' => 120.330215],
    'Tebeng' => ['lat' => 16.032023, 'lng' => 120.358877],
];
@endphp

@if($data->isNotEmpty())
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill" id="dataTable">
                <table class="table table-hover my-0">
                    <thead>
                        <tr style="color: white;">
                            <th>ID</th>
                            <th>Barangay Name</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Population</th>
                            <th class="no-print">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: white;">
                        @foreach($data as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->location }}</td>
                                <td>
                                    {{ $barangayCoordinates[ucwords(strtolower($row->location))]['lat'] ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $barangayCoordinates[ucwords(strtolower($row->location))]['lng'] ?? 'N/A' }}
                                </td>

                                <td>{{ number_format($row->population) }}</td>
                                <td class="no-print">
                                    <button class="btn btn-warning btn-sm edit-button" data-bs-toggle="modal"
                                        data-bs-target="#editModal" data-id="{{ $row->id }}" data-year="{{ $row->date }}"
                                        data-population="{{ $row->population }}" data-location="{{ $row->location }}">
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
    <p class="text-center mt-4" style="color: #000957; font-size: 18px;">No population data available.</p>
@endif
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Immunization Data Table</title>
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

    .card {
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
    
</style>

@if($data->isNotEmpty())
        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill" id="dataTable">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr style="color: white;">
                                
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

            $coverageClass = 'coverage-low';
            if ($coveragePercentage >= 80) {
                $coverageClass = 'coverage-high';
            } elseif ($coveragePercentage >= 50) {
                $coverageClass = 'coverage-medium';
            }
        @endphp
        <tr>
            
            <td>{{ date('Y', strtotime($row->date)) }}</td>
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

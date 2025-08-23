<div class="row">
    <div class="col-12">
        <div class="card shadow-sm rounded-3 border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 modern-table">
                    <thead class="bg-gradient-primary text-white rounded-top">
                        <tr>
                            <th>Staff ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @forelse ($staff as $person)
                            <tr class="shadow-sm-hover">
                                <td>{{ strtoupper($person->staff_id) }}</td>
                                <td>{{ strtoupper($person->first_name) }}</td>
                                <td>{{ strtoupper($person->last_name) }}</td>
                                <td>{{ strtoupper($person->usertype) }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn"
                                            data-id="{{ $person->id }}"
                                            data-staff_id="{{ $person->staff_id }}"
                                            data-first_name="{{ $person->first_name }}"
                                            data-last_name="{{ $person->last_name }}"
                                            data-position="{{ $person->usertype }}">
                                        Edit
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-id="{{ $person->id }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">No data found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center bg-white border-0">
                <p class="mb-0 text-muted">
                    Showing {{ $staff->firstItem() ?? 0 }} to {{ $staff->lastItem() ?? 0 }} of {{ $staff->total() ?? 0 }} results
                </p>

                <nav>
                    <ul class="pagination custom-pagination mb-0">
                        @if ($staff->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo; Previous</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $staff->appends(['search' => request()->search])->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                            </li>
                        @endif

                        @for ($i = 1; $i <= $staff->lastPage(); $i++)
                            <li class="page-item {{ $i == $staff->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $staff->appends(['search' => request()->search])->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($staff->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $staff->appends(['search' => request()->search])->nextPageUrl() }}" rel="next">Next &raquo;</a>
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

<!-- Modern Table Styles -->
<style>
    /* Table with rounded corners and subtle shadows */
    .modern-table {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #1e40af, #2563eb);
    }

    .modern-table th, .modern-table td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease-in-out;
    }

    /* Hover effect with shadow */
    .modern-table tbody tr.shadow-sm-hover:hover {
        background-color: #f1f5f9;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        border-radius: 8px;
    }

    /* Stripe effect */
    .modern-table tbody tr:nth-child(even) {
        background-color: #f9fafb;
    }

    /* Buttons modern look */
    .btn-warning {
        background-color: #fbbf24;
        border: none;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-warning:hover {
        background-color: #f59e0b;
    }

    .btn-danger {
        background-color: #ef4444;
        border: none;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-danger:hover {
        background-color: #b91c1c;
    }
</style>

<div class="row">
                        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                            <div class="card flex-fill" id="dataTable">
                                <table class="table table-hover my-0">
                                    <thead >
                                        <tr style="color: white;">
                                            <th>Staff ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Position</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
   
                                    <tbody style="background-color: white;">
    @forelse ($staff as $person)
        <tr>
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

                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $person->id }}">
    Delete
</button>

            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">No data found.</td>
        </tr>
    @endforelse
</tbody>

</table>

<div class="d-flex justify-content-between align-items-center mt-3">
    <!-- Showing X to Y of Z results -->
    <p class="mb-0" style="color: white !important;">
            Showing {{ $staff->firstItem() }} to {{ $staff->lastItem() }} of {{ $staff->total() }} results
    </p>

    <!-- Pagination Links -->
    <nav>
    <ul class="pagination custom-pagination">
        @if ($staff->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link" style="color: #000957;">&laquo; Previous</span>
            </li>
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
            <li class="page-item disabled">
                <span class="page-link" style="color: #000957;">Next &raquo;</span>
            </li>
        @endif
    </ul>
</nav>

</div>

                            </div>
                        </div>
                    </div>

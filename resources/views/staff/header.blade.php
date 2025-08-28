<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
    <a class="sidebar-toggle js-sidebar-toggle me-3">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav align-items-center">
            <!-- Optional: Notification dropdown (commented) -->
            {{--
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="bell"></i>
                        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">4</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="alertsDropdown">
                    <div class="dropdown-header fw-bold text-center py-2">Notifications</div>
                    <div class="list-group list-group-flush">
                        <!-- Notifications go here -->
                    </div>
                    <div class="dropdown-footer text-center py-2">
                        <a href="#" class="text-muted">View all</a>
                    </div>
                </div>
            </li>
            --}}

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    @php
                        $user = \Illuminate\Support\Facades\Auth::user();
                    @endphp

                    @if ($user)
                        <span class="fw-semibold text-dark me-2">
                            {{ $user->last_name }}, {{ $user->first_name }}
                        </span>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->first_name . ' ' . $user->last_name) }}&background=0D8ABC&color=fff" 
                             class="rounded-circle" width="32" height="32" alt="User Avatar">
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                    <!-- <li><a class="dropdown-item" href="#"><i class="me-2" data-feather="user"></i>Profile</a></li> -->
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

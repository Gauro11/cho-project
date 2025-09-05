<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
    <a class="sidebar-toggle js-sidebar-toggle me-3">
        <i class="hamburger align-self-center"></i>
    </a>

    <!-- Mobile toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item dropdown">
                @php
                    $user = \Illuminate\Support\Facades\Auth::user();
                @endphp

                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    @if ($user)
                        <span class="fw-semibold text-dark me-2">
                            {{ $user->last_name }}, {{ $user->first_name }}
                        </span>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->first_name . ' ' . $user->last_name) }}&background=0D8ABC&color=fff" 
                             class="rounded-circle" width="32" height="32" alt="User Avatar">
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="me-2" data-feather="log-out" style="width: 16px; height: 16px;"></i>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

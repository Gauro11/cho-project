<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
    <a class="sidebar-toggle js-sidebar-toggle me-3">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav align-items-center">
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
                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="me-2" data-feather="log-out"></i>Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

{{-- 🔒 Prevent back after logout --}}
<script>
    // When logout happens, clear history cache
    document.getElementById('logoutForm').addEventListener('submit', function() {
        if (window.history && window.history.pushState) {
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function () {
                window.location.replace("{{ route('login') }}");
            };
        }
    });

    // Also block cached pages on load (for when user presses back)
    window.onload = function() {
        if (!@json(Auth::check())) {
            window.location.replace("{{ route('login') }}");
        }
    };
</script>

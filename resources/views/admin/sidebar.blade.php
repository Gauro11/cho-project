<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        @if(Auth::guard('admin')->check())
            <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
                <center>
                    <span class="align-middle">
                        <img src="{{ asset('image/dag_logo.png') }}" alt="" style="width: 100px; height: auto;">
                    </span>
                </center>
            </a>
        @elseif(Auth::guard('staff')->check())
            <a class="sidebar-brand" href="{{ route('staff.dashboard') }}">
                <center>
                    <span class="align-middle">
                        <img src="{{ asset('image/dag_logo.png') }}" alt="" style="width: 100px; height: auto;">
                    </span>
                </center>
            </a>
        @endif

        <ul class="sidebar-nav">
            @if(Auth::guard('admin')->check())
                <li class="sidebar-item active">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                        <i class="align-middle" data-feather="grid"></i> 
                        <span class="align-middle">Admin Overview</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('show_staff') }}">
                        <i class="align-middle" data-feather="users"></i> 
                        <span class="align-middle">Staff Management</span>
                    </a>
                </li>
            @endif

            @if(Auth::guard('staff')->check())
                <li class="sidebar-item active">
                    <a class="sidebar-link" href="{{ route('staff.dashboard') }}">
                        <i class="align-middle" data-feather="grid"></i> 
                        <span class="align-middle">Staff Overview</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('immunization.show') }}">
                        <i class="align-middle" data-feather="activity"></i> 
                        <span class="align-middle">Immunization</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('show_vital_statistics') }}">
                        <i class="align-middle" data-feather="bar-chart-2"></i> 
                        <span class="align-middle">Vital Statistics</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('show_population') }}">
                        <i class="align-middle" data-feather="users"></i> 
                        <span class="align-middle">Population</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('show_morbidity') }}">
                        <i class="align-middle" data-feather="activity"></i> 
                        <span class="align-middle">Morbidity</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('show_mortality') }}">
                        <i class="align-middle" data-feather="alert-triangle"></i> 
                        <span class="align-middle">Mortality</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('show_trends') }}">
                        <i class="align-middle" data-feather="trending-up"></i> 
                        <span class="align-middle">Trends</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>

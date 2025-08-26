<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Sidebar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100%;
            background: #1e293b; /* dark background */
            color: white;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-content {
            height: 100%;
            overflow-y: auto;
        }

        .sidebar-nav {
            list-style: none;
            padding: 24px 0;
            flex: 1;
        }

        .sidebar-item {
            margin: 0 12px 8px;
            position: relative;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 16px;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 15px;
            backdrop-filter: blur(10px);
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(8px);
        }

        .sidebar-item.active .sidebar-link {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-item.active::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 32px;
            background: linear-gradient(135deg, #ff6b6b, #feca57);
            border-radius: 2px;
        }

        .sidebar-link i {
            width: 24px;
            height: 24px;
            margin-right: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover i {
            transform: scale(1.2);
        }

        .sidebar-item.active .sidebar-link i {
            color: #ff6b6b;
        }

        /* Main content */
        .main-content {
            margin-left: 280px;
            padding: 24px;
            background: #f8fafc;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: inline-block;
            }
        }

        /* Toggle button */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background: #1e293b;
            color: white;
            border: none;
            padding: 10px 12px;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Toggle button for mobile -->
<button class="mobile-toggle" onclick="toggleSidebar()">☰</button>

<!-- Sidebar -->
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <center>
                <span class="align-middle">
                    <img src="image/dag_logo.png" alt="" style="width: 100px; height: auto;">
                </span>
            </center>
        </a>
        <ul class="sidebar-nav">

            <li class="sidebar-item active">
                <a class="sidebar-link" href="{{url('/staff')}}">
                    <i class="align-middle" data-feather="grid"></i> 
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{url('show_immunization')}}">
                    <i class="align-middle" data-feather="shield"></i> 
                    <span class="align-middle">Immunization</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{url('show_vital_statistics')}}">
                    <i class="align-middle" data-feather="activity"></i> 
                    <span class="align-middle">Vital Statistics</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{url('show_population')}}">
                    <i class="align-middle" data-feather="users"></i> 
                    <span class="align-middle">Population Statistics</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{url('show_morbidity')}}">
                    <i class="align-middle" data-feather="thermometer"></i> 
                    <span class="align-middle">Morbidity Records</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{url('show_mortality')}}">
                    <i class="align-middle" data-feather="heart"></i> 
                    <span class="align-middle">Mortality Records</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{url('show_trends')}}">
                    <i class="align-middle" data-feather="pie-chart"></i> 
                    <span class="align-middle">Trends</span>
                </a>
            </li>

        </ul>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">
    <h1>Welcome!</h1>
    <p>This is the main content area.</p>
</div>

<script>
    // Active link highlighting
    document.addEventListener("DOMContentLoaded", function () {
        let currentUrl = window.location.href;
        let sidebarLinks = document.querySelectorAll(".sidebar-link");

        sidebarLinks.forEach(link => {
            if (link.href === currentUrl) {
                link.closest(".sidebar-item").classList.add("active");
            } else {
                link.closest(".sidebar-item").classList.remove("active");
            }
        });
    });

    // Sidebar toggle for mobile
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("open");
    }
</script>

</body>
</html>

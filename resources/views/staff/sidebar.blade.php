<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern Sidebar</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.css" rel="stylesheet">

  <style>
    /* Base sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 280px;
      background: #0a2a66; /* Dagupan blue */
      color: #fff;
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease;
      z-index: 1000;
    }

    .sidebar-content {
      flex: 1;
      overflow-y: auto;
      padding: 24px 0;
    }

    .sidebar-nav {
      list-style: none;
      margin: 0;
      padding: 0;
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
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      font-weight: 500;
      font-size: 15px;
    }

    .sidebar-link:hover {
      color: #fff;
      background: rgba(255, 255, 255, 0.15);
      transform: translateX(8px);
      box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    }

    .sidebar-item.active .sidebar-link {
      background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
      color: #fff;
      box-shadow: 0 12px 40px rgba(0,0,0,0.15);
      border: 1px solid rgba(255,255,255,0.2);
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
      box-shadow: 0 0 20px rgba(255,107,107,0.4);
    }

    .sidebar-link i {
      width: 24px;
      height: 24px;
      margin-right: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.3s ease;
    }

    .sidebar-link:hover i {
      transform: scale(1.2);
    }

    /* Main content */
    .main-content {
      margin-left: 280px;
      padding: 24px;
      background: #f8fafc;
      min-height: 100vh;
      transition: margin-left 0.3s ease;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        width: 260px;
      }
      .sidebar.open {
        transform: translateX(0);
      }
      .main-content {
        margin-left: 0;
      }
      .menu-toggle {
        position: fixed;
        top: 20px;
        left: 20px;
        background: #0a2a66;
        color: #fff;
        padding: 10px 15px;
        border-radius: 6px;
        cursor: pointer;
        z-index: 1100;
      }
    }
  </style>
</head>

<body>
  <!-- Mobile toggle -->
  <div class="menu-toggle" id="menuToggle">☰</div>

  <!-- Sidebar -->
  <nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
      <a class="sidebar-brand" href="index.html">
        <center>
          <span class="align-middle"><img src="image/dag_logo.png" alt="" style="width: 100px; height: auto;"></span>
        </center>
      </a>
      <ul class="sidebar-nav">
        <li class="sidebar-item active">
          <a class="sidebar-link" href="{{url('/staff')}}">
            <i data-feather="grid"></i> <span class="align-middle">Dashboard</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{url('show_immunization')}}">
            <i data-feather="shield"></i> <span class="align-middle">Immunization</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{url('show_vital_statistics')}}">
            <i data-feather="activity"></i> <span class="align-middle">Vital Statistics</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{url('show_population')}}">
            <i data-feather="users"></i> <span class="align-middle">Population Statistics</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{url('show_morbidity')}}">
            <i data-feather="thermometer"></i> <span class="align-middle">Morbidity Records</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{url('show_mortality')}}">
            <i data-feather="heart"></i> <span class="align-middle">Mortality Records</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{url('show_trends')}}">
            <i data-feather="pie-chart"></i> <span class="align-middle">Trends</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <h1>Welcome!</h1>
    <p>This is the dashboard content area.</p>
  </div>

  <script>
    // Feather icons init
    feather.replace();

    // Highlight active link
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

    // Mobile toggle
    document.getElementById("menuToggle").addEventListener("click", function() {
      document.getElementById("sidebar").classList.toggle("open");
    });
  </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Sidebar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-content {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 24px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 0;
        }

        .sidebar-brand img {
            width: 100px;
            height: auto;
        }

        .sidebar-nav {
            list-style: none;
            padding: 24px 0;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-weight: 500;
            font-size: 15px;
            backdrop-filter: blur(10px);
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(8px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .sidebar-link:hover::before {
            left: 100%;
        }

        .sidebar-item.active .sidebar-link {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
            color: #ffffff;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
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
            box-shadow: 0 0 20px rgba(255, 107, 107, 0.4);
        }

        .sidebar-link i {
            width: 24px;
            height: 24px;
            margin-right: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover i {
            transform: scale(1.2);
        }

        .sidebar-item.active .sidebar-link i {
            color: #ff6b6b;
            filter: drop-shadow(0 0 8px rgba(255, 107, 107, 0.3));
        }

        .align-middle {
            position: relative;
            z-index: 2;
        }

        /* Glassmorphism effect */
        .sidebar-item:hover .sidebar-link {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 16px 50px rgba(0, 0, 0, 0.1);
        }

        /* Mobile hamburger menu */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .mobile-menu-btn i {
            color: white;
            font-size: 24px;
        }

        /* Mobile overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .sidebar {
                width: 280px;
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
            }

            .mobile-menu-btn {
                display: block;
            }

            .sidebar-overlay {
                display: block;
            }
        }

        /* Demo content area */
        .main-content {
            margin-left: 280px;
            padding: 24px;
            background: #f8fafc;
            min-height: 100vh;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding-top: 80px;
            }
        }

        /* Loading animation for icons */
        @keyframes iconPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .sidebar-item.active .sidebar-link i {
            animation: iconPulse 2s infinite;
        }

        /* Hover effects for better interactivity */
        .sidebar-link:active {
            transform: translateX(4px) scale(0.98);
        }

        /* Smooth scrollbar */
        .sidebar-content {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }
    </style>
</head>
<body>

<!-- Mobile Menu Button -->
<button class="mobile-menu-btn" onclick="toggleSidebar()">
    <i data-feather="menu"></i>
</button>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="index.html">
			<center>
			<span class="align-middle"><img src="image/dag_logo.png" alt="" style="width: 100px; height: auto;">
			</span>
			</center>
		</a>
		<ul class="sidebar-nav">

			<li class="sidebar-item active">
				<a class="sidebar-link" href="{{url('/staff')}}">
					<i class="align-middle" data-feather="grid"></i> <span class="align-middle">Dashboard</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="{{url('show_immunization')}}">
					<i class="align-middle" data-feather="shield"></i> <span class="align-middle">Immunization</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="{{url('show_vital_statistics')}}">
					<i class="align-middle" data-feather="activity"></i> <span class="align-middle">Vital Statistics</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="{{url('show_population')}}">
					<i class="align-middle" data-feather="users"></i> <span class="align-middle">Population Statistics</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="{{url('show_morbidity')}}">
					<i class="align-middle" data-feather="thermometer"></i> <span class="align-middle">Morbidity Records</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="{{url('show_mortality')}}">
					<i class="align-middle" data-feather="heart"></i> <span class="align-middle">Mortality Records</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="{{url('show_trends')}}">
					<i class="align-middle" data-feather="pie-chart"></i> <span class="align-middle">Trends</span>
				</a>
			</li>
		</ul>
	</div>
</nav>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		let currentUrl = window.location.href; // Get current URL
		let sidebarLinks = document.querySelectorAll(".sidebar-link");

		sidebarLinks.forEach(link => {
			if (link.href === currentUrl) {
				link.closest(".sidebar-item").classList.add("active");
			} else {
				link.closest(".sidebar-item").classList.remove("active");
			}
		});
	});
</script>
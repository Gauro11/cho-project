<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href={{url('/home')}}>
			<center>
				<span class="align-middle">
					<img src="image/dag_logo.png" alt="" style="width: 100px; height: auto;">
				</span>
			</center>
		</a>

		<ul class="sidebar-nav">

			<li class="sidebar-item active">
				<a class="sidebar-link" href={{url('/home')}}>
					<i class="align-middle" data-feather="grid"></i> 
					<span class="align-middle">Admin Overview</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="{{url('show_staff')}}">
					<i class="align-middle" data-feather="users"></i> 
					<span class="align-middle">Staff Management</span>
				</a>
			</li>

		</ul>
	</div>
</nav>

<style>
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
		animation: iconPulse 2s infinite;
	}

	.align-middle {
		position: relative;
		z-index: 2;
	}

	.sidebar-item:hover .sidebar-link {
		background: rgba(255, 255, 255, 0.2);
		border: 1px solid rgba(255, 255, 255, 0.3);
		box-shadow: 0 16px 50px rgba(0, 0, 0, 0.1);
	}

	@keyframes iconPulse {
		0%, 100% { transform: scale(1); opacity: 1; }
		50% { transform: scale(1.1); opacity: 0.8; }
	}

	/* Responsive */
	@media (max-width: 768px) {
		.sidebar { width: 260px; transform: translateX(-100%); }
		.sidebar.open { transform: translateX(0); }
	}
</style>

<script>
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

	let sidebarToggle = document.querySelector(".js-sidebar-toggle");
	let sidebar = document.getElementById("sidebar");

	if (sidebarToggle && sidebar) {
		sidebarToggle.addEventListener("click", function (e) {
			e.preventDefault();
			sidebar.classList.toggle("open");
		});
	}
});
</script>

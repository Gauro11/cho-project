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
				<a class="sidebar-link" href="{{url('/home')}}">
					<i class="align-middle" data-feather="grid"></i> <span class="align-middle">Dashboard</span>
				</a>
			</li>


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




			<!-- <li class="sidebar-item">
				<a class="sidebar-link" href="">
					<i class="align-middle" data-feather="book"></i> <span class="align-middle">Reports</span>
				</a>
			</li> -->

			<!-- <li class="sidebar-item">
				<a class="sidebar-link" href="#">
					<i class="align-middle" data-feather="settings"></i> <span
						class="align-middle">Settings</span>
				</a>
			</li> -->

			

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
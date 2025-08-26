            
            
<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href={{url('/home')}}>
			<center>
			<span class="align-middle"><img src="image/dag_logo.png" alt="" style="width: 100px; height: auto;">
			</span>
			</center>
		</a>
		<ul class="sidebar-nav">

			<li class="sidebar-item active">
				<a class="sidebar-link" href="{{url('/home')}}">
					<i class="align-middle" data-feather="grid"></i> <span class="align-middle">Immunization Overview</span>
				</a>
			</li>


			</li>


			<li class="sidebar-item">
				<a class="sidebar-link" href="{{url('show_immunization')}}">
					<i class="align-middle" data-feather="database"></i> <span class="align-middle">Immunization</span>
				</a>
			</li>

			


			<li class="sidebar-item">
				<a class="sidebar-link" href="#">
					<i class="align-middle" data-feather="pie-chart"></i> <span class="align-middle">Trends</span>
				</a>
			</li>



			<li class="sidebar-item">
				<a class="sidebar-link" href="">
					<i class="align-middle" data-feather="book"></i> <span class="align-middle">Reports</span>
				</a>
			</li>

			

		</ul>


	</div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Highlight active link
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
</script>
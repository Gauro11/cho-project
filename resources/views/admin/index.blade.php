<!DOCTYPE html>
<html lang="en">

<head>
	@include('staff.css')
</head>

<body>
	<div class="wrapper">
	@include('admin.sidebar')

		<div class="main">
			@include('staff.header')

			<main class="content">
				@include('admin.analytics')
			</main>

			@include('staff.footer')
		</div>
	</div>

@include('staff.js')

</body>

</html>
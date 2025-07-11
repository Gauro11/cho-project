<!DOCTYPE html>
<html lang="en">

<head>
	@include('staff.css')
</head>

<body>
	<div class="wrapper">
	@include('immunization.sidebar')

		<div class="main">
			@include('staff.header')

			<main class="content">
				@include('immunization.analytics')
			</main>

			@include('staff.footer')
		</div>
	</div>

@include('staff.js')

</body>

</html>
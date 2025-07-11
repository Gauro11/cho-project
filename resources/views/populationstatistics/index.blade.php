<!DOCTYPE html>
<html lang="en">

<head>
	@include('staff.css')
</head>

<body>
	<div class="wrapper">
	@include('populationstatistics.sidebar')

		<div class="main">
			@include('staff.header')

			<main class="content">
				@include('populationstatistics.analytics')
			</main>

			@include('staff.footer')
		</div>
	</div>

@include('staff.js')

</body>

</html>
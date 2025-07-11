<!DOCTYPE html>
<html lang="en">

<head>
	@include('staff.css')
</head>

<body>
	<div class="wrapper">
	@include('morbiditymortality.sidebar')

		<div class="main">
			@include('staff.header')

			<main class="content">
				@include('morbiditymortality.analytics')
			</main>

			@include('staff.footer')
		</div>
	</div>

@include('staff.js')

</body>

</html>
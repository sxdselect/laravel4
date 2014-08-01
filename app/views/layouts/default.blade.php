<!DOCTYPE html>
<html lang="en-zh">
	<head>
		@include('layouts.header')
	</head>
	<body>
		<!-- #page-header -->
		@include('layouts.nav')
		<!-- #page-header -->

		<div id="page-wrapper" class="container">
			<div id="page-sidebar">
				@include('layouts.sidebar')
			</div><!-- #page-sidebar -->

			<div id="page-main">
				<div id="page-breadcrumb-wrapper">
					@include('layouts.breadcrumb')
				</div><!-- #page-breadcrumb_wrapper -->
				
				<div id="page-content">
					@yield('content')
				</div><!-- #page-content -->
			</div><!-- #page-main -->
		</div><!-- #page-wrapper -->

		<div id="page-footer">
			@include('layouts.footer')
		</div><!-- #page-footer -->
	</body>
</html>
<!DOCTYPE html>
@inject('bear', 'Rudivdme\BearContent\BearContent')
<html>
	<head>
		<meta charset="utf-8">
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel='stylesheet' type='text/css' href='{{ url("css/app.css") }}'>
		{!! $bear->styles() !!}
		@yield('meta')
	</head>

	<body class="{{ $bear->classnames() }}">

		@include('bear::app')

		<div id="front">

			@yield('content')

		</div>

		<script type='text/javascript' src='{{ url("js/app.js") }}'></script>
		{!! $bear->scripts() !!}

	</body>
</html>

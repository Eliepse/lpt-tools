<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
	<script src="{{ mix('js/react/index.js') }}" defer></script>

	<!-- Styles -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;700&display=swap" rel="stylesheet">
	<link href="{{ mix('css/antd.css') }}" rel="stylesheet">
</head>
<body>
<div id="app"></div>
</body>
</html>

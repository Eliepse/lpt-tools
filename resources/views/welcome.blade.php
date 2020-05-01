<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Les petits trilingues - Outils</title>

	<!-- Fonts -->
	<link href="{{ mix("css/styles.css") }}" rel="stylesheet" type="text/css">
</head>
<body class="page--welcome">
<main class="welcome__main">
	<div class="welcome__content">
		<h1 class="welcome__title">les petits trilingues</h1>
		<ul class="welcom__links">
			<li><a href="http://www.lespetitstrilingues.com">Website</a>&nbsp;&rightarrow;</li>
			<li><a href="{{ route('exercice.chinese-grid') }}">Grid generator (cn)</a>&nbsp;&rightarrow;</li>
			<li><a href="{{ route('exercice.english-grid') }}">Grid generator (en)</a>&nbsp;&rightarrow;</li>
		</ul>
	</div>
</main>
</body>
</html>

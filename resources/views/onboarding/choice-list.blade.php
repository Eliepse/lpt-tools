<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Inscription - LPT</title>
	<link href="{{ mix("/css/styles.css") }}" rel="stylesheet" type="text/css">
</head>

<body class="page--onboarding">

<main id="app">
	<div class="container">
		<h1 class="onb__title">{{ $title }}</h1>
		<ul class="onb-list">
			@foreach($cards as $card)
				<li>
					<a class="onb-card onb-card--full" href="{{ $card["link"] }}">{{ $card["title"] }}</a>
				</li>
			@endforeach
		</ul>
	</div>
</main>

<script src="{{ mix('/js/app.js') }}"></script>

</body>
</html>
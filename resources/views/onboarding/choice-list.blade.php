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
		@isset($back)
			<a class="onb-card onb-card--interactive" href="{{ $back["link"] }}">{{ $back["text"] }}</a>
		@endisset
		<ul class="onb-list">
			@foreach($cards as $card)
				<li>
					<a class="onb-card onb-card--interactive onb-card--full" href="{{ $card["link"] }}">
						@isset($card["price"])
							<div class="onb-card__price">{{ $card["price"] }}&nbsp;€</div>
						@endisset

						<h2 class="onb-card__title">{{ $card["title"] }}</h2>

						@isset($card["description"])
							<div class="onb-card__description">{!! nl2br(e($card["description"])) !!}</div>
						@endisset
					</a>
				</li>
			@endforeach
		</ul>
	</div>
</main>

<script src="{{ mix('/js/app.js') }}"></script>

</body>
</html>
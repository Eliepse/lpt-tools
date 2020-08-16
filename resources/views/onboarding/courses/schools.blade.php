<?php /** TODO slit code (master, header, footer, ...) */ ?>
<?php ?><!doctype html>
<html lang="{{ \Illuminate\Support\Facades\App::getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Inscription Écoles - LPT {{-- TODO translation --}}</title>
	<link href="{{ mix("/css/onboarding.css") }}" rel="stylesheet" type="text/css">
</head>

<body class="page onboarding onboarding--schools">

@include("onboarding.courses.components.decorations", ["withAnts" => false])

<header class="onboarding-header">
	<a class="lpt-logo" href="http://www.lespetitstrilingues.com">
		<img src="/images/logo.gif" width="70" alt="Logo Les Petits Trilingues">
	</a>
	<div class="onboarding-header__text">
		<a href="{{ route("onboarding.welcome") }}" class="onboarding-header__backBtn">
			<svg xmlns="http://www.w3.org/2000/svg" width="19" height="12" fill="none">
				<path fill-rule="evenodd" d="M.5 6.5c-.3-.3-.3-.8 0-1.1L5.2.7c.3-.3.8-.3 1.1 0s.3.8 0 1.1L2.8 5.3H19v1.5H2.8l3.5 3.5c.3.3.3.8 0 1.1s-.8.3-1.1 0L.5 6.5z" fill="#0da84a"/>
			</svg>
			&nbsp;
			@lang("onboarding.buttons.previous")
		</a>
		<hr>
		<h1 class="onboarding-header__title">@lang("onboarding.ourSchools")</h1>
	</div>
	<div class="header-flags">
		<a href="javascript:void(0)">
			<svg xmlns="http://www.w3.org/2000/svg" width="41" height="27" fill="none" viewBox="0 0 41 27">
				<path d="M40.5 0H0V27H40.5V0Z" fill="#de2910"/>
				<path d="M6.7 2.7L9.1 10 2.9 5.5h7.7L4.4 10l2.4-7.3zM14 1.5L13.8 4l-1.3-2.2 2.4 1-2.5.6L14 1.5zm3.2 3L16 6.7l-.4-2.5L17.4 6l-2.5-.4 2.3-1.1zm.3 4.5l-2 1.6.7-2.5.9 2.4L15 9.1l2.6-.1zM14 10.9l-.1 2.6-1.4-2.1 2.4.9-2.5.7 1.6-2z" fill="#ffde00"/>
			</svg>
		</a>
		<a href="javascript:void(0)">
			<svg xmlns="http://www.w3.org/2000/svg" width="41" height="27" fill="none" viewBox="0 0 41 27">
				<path d="M41 0H.5v27H41V0z" fill="#ed2939"/>
				<path d="M27.5 0H.5v27h27V0z" fill="#fff"/>
				<path d="M14 0H.5v27H14V0z" fill="#002395"/>
			</svg>
		</a>
	</div>
</header>

<main id="app" class="onboarding-main">
	<div class="container">
		<ul class="onboarding-choiceList">
			@foreach($schools as $school)
				<li>
					@component("onboarding.courses.components.button")
						@slot("link", route("onboarding.categories", $school))
						{{ trans("onboarding.schools." . $school . ".name") }}<br>
						@if($loc = trans("onboarding.schools." . $school . ".location"))
							({{ $loc }})
						@endif
					@endcomponent
				</li>
			@endforeach
		</ul>
	</div>
</main>

<footer class="onboarding-footer">
	<a class="lpt-logo" href="http://www.lespetitstrilingues.com">
		<img src="/images/logo.gif" width="68" alt="Logo Les Petits Trilingues">
	</a>
</footer>

<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
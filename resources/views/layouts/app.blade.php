<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
{{--	<script src="{{ asset('js/app.js') }}" defer></script>--}}

<!-- Styles -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;700&display=swap" rel="stylesheet">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
	<nav class="fixed inset-x-0 top-0 shadow-sm bg-white">
		<div class="container mx-auto flex flex-row justify-between items-center">

			<a class="text-xl font-bold capitalize text-blue-700" href="{{ url('/home') }}">
				{{ config('app.name', 'LPT') }}
			</a>

			<div class="flex flex-row justify-end align-middle" id="navbarSupportedContent">
				<!-- Left Side Of Navbar -->
				<ul class="">
					<li class="inline-block">
						<a
							class="inline-block px-6 py-4 hover:underline"
							href="{{ route("registrations") }}"
						>
							Inscriptions
						</a>
					</li>
				</ul>

				<!-- Right Side Of Navbar -->
				<ul class="ml-auto">
					<!-- Authentication Links -->
					@guest
						<li><a class="inline-block px-6 py-4 hover:bg-gray-100" href="{{ route('login') }}">{{ __('Login') }}</a>
						</li>
						@if (Route::has('register'))
							<li>
								<a class="inline-block px-6 py-4 hover:bg-gray-100" href="{{ route('register') }}">{{ __('Register') }}</a>
							</li>
						@endif
					@else
						<li class="relative" id="user-menu">
							<a
								id="navbarDropdown"
								class="inline-block px-6 py-4 hover:bg-gray-100"
								href="#"
								role="button"
								data-toggle="dropdown"
							>
								🎓 {{ Auth::user()->name }}
							</a>

							<div
								class="hidden absolute top-full right-0 bg-white rounded shadow w-48"
								aria-labelledby="navbarDropdown"
							>

								<a
									class="block px-4 py-2 hover:bg-gray-100"
									href="{{ route('logout') }}"
									onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
								>
									{{ __('Logout') }}
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</div>

							<script>
								var dropdown = document.querySelector("[aria-labelledby=navbarDropdown]");
								document.querySelector("#user-menu").addEventListener("mouseenter", function (event) {
									dropdown.classList.remove("hidden");
								});
								document.querySelector("#user-menu").addEventListener("mouseleave", function (event) {
									dropdown.classList.add("hidden");
								});
							</script>

						</li>
					@endguest
				</ul>
			</div>
		</div>
	</nav>

	<main class="pt-16 py-4">
		@yield('content')
	</main>
</div>
</body>
</html>

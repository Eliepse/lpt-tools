@extends('layouts.app')

@section('content')
	<div class="container m-auto max-w-5xl">
		<div class="mt-12 mb-8 text-3xl font-bold">Connexion</div>

		<form method="POST" action="{{ route('login') }}">
			@csrf

			<div class="mb-4">
				<label for="email" class="block mb-2 text-sm text-gray-600">{{ __('E-Mail Address') }}</label>

				<input
					id="email"
					type="email"
					class="rounded px-4 py-2 text-xl border border-gray-300 @error('email') border-red-600 @enderror"
					name="email"
					value="{{ old('email') }}"
					required
					autocomplete="email"
					autofocus
				>
				@error('email')
				<span class="text-red-600" role="alert"><strong>{{ $message }}</strong></span>
				@enderror
			</div>

			<div class="mb-4">
				<label for="password" class="block mb-2 text-sm text-gray-600">{{ __('Password') }}</label>

				<input
					id="password"
					type="password"
					class="rounded px-4 py-2 text-xl border border-gray-300 @error('password') border-red-600 @enderror"
					name="password"
					required
					autocomplete="current-password"
				>

				@error('password')
				<span class="text-red-600" role="alert"><strong>{{ $message }}</strong></span>
				@enderror
			</div>

			<div class="mb-8">
				<div class="col-md-6 offset-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
						<label class="form-check-label" for="remember">Rester connecté</label>
					</div>
				</div>
			</div>

			<div class="form-group row mb-0">
				<div class="col-md-8 offset-md-4">
					<button type="submit" class="px-6 py-4 bg-green-600 text-white leading-none rounded hover:bg-green-800">
						{{ __('Login') }}
					</button>

					@if (Route::has('password.request'))
						<a class="btn btn-link" href="{{ route('password.request') }}">
							{{ __('Forgot Your Password?') }}
						</a>
					@endif
				</div>
			</div>
		</form>
	</div>
@endsection

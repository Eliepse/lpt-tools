<?php
/**
 * @var \Illuminate\Support\MessageBag $errors
 */
?>
		<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../../../favicon.ico">

	<title>Signin Template for Bootstrap</title>

	<!-- Bootstrap core CSS -->
	<link href="/css/app.css" rel="stylesheet">
</head>

<body>

<div class="container">

	<div class="row mt-5 mb-5">

		<div class="card col-sm-9 col-lg-5 m-auto">

			<div class="card-body">

				<h1 class="card-title">Working grid</h1>
				<p class="card-text">This tool allow you to easily create a working grid for chinese characters, with or without stroke order indication.</p>
				<form action="{{ route('workingGrid.pdf') }}" method="GET">

					<div class="form-group">
						<label for="characters">Title</label>
						<input type="text" id="characters" name="title" class="form-control" placeholder="Working grid - level A2" required autofocus maxlength="50" value="{{ old('title') }}">
					</div>

					<div class="form-group">
						<label for="characters">Characters</label>
						<input type="text" id="characters" name="characters" class="form-control mb-3 {{ $errors->has('characters') ? 'is-invalid' : '' }}" placeholder="两口中水小大多少。。。" value="{{ old('characters') }}" required>
						@if($errors->has('characters'))
							<div class="invalid-feedback">{{ $errors->first('characters') }}</div>
						@endif
					</div>

					<p class="text-muted mb-0">Options</p>
					<hr class="mt-0">

					<div class="form-group input-group">
						<div class="input-group-prepend">
							<label class="input-group-text" for="strokeHelp">with stroke order</label>
						</div>
						<div class="input-group-append">
							<div class="input-group-text">
								<input type="checkbox" class="{{ $errors->has('strokeHelp') ? 'is-invalid' : '' }}" id="strokeHelp" name="strokeHelp" value="{{ old('strokeHelp', true) }}">
							</div>
						</div>
						@if($errors->has('strokeHelp'))
							<div class="invalid-feedback">{{ $errors->first('strokeHelp') }}</div>
						@endif
					</div>

					<div class="form-group input-group">
						<div class="input-group-prepend">
							<label class="input-group-text" for="columns">cells per line</label>
						</div>
						<input class="form-control {{ $errors->has('columns') ? 'is-invalid' : '' }}" type="number" min="6" max="20" id="columns" name="columns" value="{{ old('columns', 9) }}">
						@if($errors->has('columns'))
							<div class="invalid-feedback">{{ $errors->first('columns') }}</div>
						@endif
					</div>

					{{--<div class="form-group input-group">--}}
					{{--<div class="input-group-prepend">--}}
					{{--<label class="input-group-text" for="lines">lines per page</label>--}}
					{{--</div>--}}
					{{--<input class="form-control {{ $errors->has('lines') ? 'is-invalid' : '' }}" type="number" min="1" max="20" id="lines" name="lines" value="{{ old('lines', 10) }}">--}}
					{{--@if($errors->has('lines'))--}}
					{{--<div class="invalid-feedback">{{ $errors->first('lines') }}</div>--}}
					{{--@endif--}}
					{{--</div>--}}

					<div class="form-group input-group">
						<div class="input-group-prepend">
							<label class="input-group-text" for="models">gray characters</label>
						</div>
						<input class="form-control {{ $errors->has('models') ? 'is-invalid' : '' }}" type="number" min="0" max="20" id="models" name="models" value="{{ old('models', 3) }}">
						@if($errors->has('models'))
							<div class="invalid-feedback">{{ $errors->first('models') }}</div>
						@endif
					</div>

					<button class="btn btn-primary" type="submit">Generate !</button>

				</form>
			</div>

		</div>

	</div>

</div>
</body>
</html>
